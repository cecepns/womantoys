<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Voucher;
use App\Models\VoucherUsage;
use Illuminate\Http\Request;
use App\Models\Setting;

class CheckoutController extends Controller
{
    /**
     * ANCHOR: Display checkout page for a specific product.
     */
    public function index(Request $request)
    {
        // Get product ID from query parameter
        $productId = $request->query('product');

        if (!$productId) {
            return redirect()->route('catalog')->with('error', 'Produk tidak ditemukan.');
        }

        // Load product with relationships
        $product = Product::with(['category', 'images'])
            ->where('id', $productId)
            ->where('status', 'active')
            ->first();

        if (!$product) {
            return redirect()->route('catalog')->with('error', 'Produk tidak ditemukan.');
        }

        // Check stock availability
        if ($product->stock <= 0) {
            return redirect()->route('product-detail', $product->slug)->with('error', 'Stok produk habis.');
        }

        // Get store origin ID for shipping calculation
        $originId = (int) Setting::getValue('store_origin_id', 17473);
        return view('checkout', compact('product', 'originId'));
    }

    /**
     * ANCHOR: Process checkout and create order.
     */
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'fullName' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address_location' => 'required|string|max:255',
            'address_detail' => 'required|string',
            'shipping' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'origin_id' => 'required|integer',
            'destination_id' => 'required|integer',
            'voucher_id' => 'nullable|exists:vouchers,id',
            'voucher_code' => 'nullable|string',
            'discount_amount' => 'nullable|numeric|min:0'
        ]);

        // Get product
        $product = Product::findOrFail($request->product_id);

        // Validate stock availability
        if ($product->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Stok tidak mencukupi untuk jumlah yang dipilih.'])->withInput();
        }

        // Parse shipping data from format: courier_service_cost
        $shippingData = explode('_', $request->shipping);
        $courier = $shippingData[0] ?? 'unknown';
        $service = $shippingData[1] ?? 'unknown';
        $shippingCost = (int)($shippingData[2] ?? 0);

        // Calculate order costs
        $subtotal = $product->final_price * $request->quantity;
        $discountAmount = 0;
        $voucher = null;

        // Handle voucher if provided
        if ($request->filled('voucher_id') && $request->filled('voucher_code')) {
            $voucher = Voucher::find($request->voucher_id);

            if ($voucher && $voucher->code === $request->voucher_code) {
                // Validate voucher for this specific order
                $cart = [['total' => $subtotal]];
                $validation = $voucher->validateForUse($cart, $request->email);

                if ($validation['valid']) {
                    // Calculate discount
                    if ($voucher->type === 'free_shipping') {
                        $discountAmount = 0; // No discount amount for free shipping
                        $shippingCost = 0; // Set shipping to 0 for free shipping
                    } else {
                        $discountAmount = $voucher->calculateDiscount($subtotal, $shippingCost);
                    }
                } else {
                    return back()->withErrors(['voucher' => $validation['message']])->withInput();
                }
            } else {
                return back()->withErrors(['voucher' => 'Voucher tidak valid.'])->withInput();
            }
        }

        // Calculate final total
        $totalAmount = $subtotal + $shippingCost - $discountAmount;

        // Ensure total is not negative
        if ($totalAmount < 0) {
            $totalAmount = 0;
        }

        // Combine address fields for storage
        $fullAddress = $request->address_location . "\n" . $request->address_detail;

        // Create order record
        $order = \App\Models\Order::create([
            'customer_name' => $request->fullName,
            'customer_phone' => $request->phone,
            'customer_email' => $request->email,
            'shipping_address' => $fullAddress,
            'shipping_method' => $courier . ' - ' . $service,
            'shipping_cost' => $shippingCost,
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'voucher_id' => $voucher ? $voucher->id : null,
        ]);

        // Create order item record
        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => $product->final_price,
            'original_price' => $product->price,
            'quantity' => $request->quantity,
        ]);

        // Track voucher usage if voucher was used
        if ($voucher) {
            VoucherUsage::create([
                'voucher_id' => $voucher->id,
                'order_id' => $order->id,
                'customer_email' => $request->email,
                'discount_amount' => $discountAmount,
            ]);

            // Increment voucher usage count
            $voucher->increment('used_count');
        }

        // Update product stock
        $product->decrement('stock', $request->quantity);

        // Redirect to payment instruction with order number
        return redirect()->route('payment-instruction', ['order' => $order->order_number])
            ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }
}
