<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
            'destination_id' => 'required|integer'
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
        $subtotal = $product->price * $request->quantity;
        $totalAmount = $subtotal + $shippingCost;

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
            'total_amount' => $totalAmount,
        ]);

        // Create order item record
        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => $product->price,
            'quantity' => $request->quantity,
        ]);

        // Update product stock
        $product->decrement('stock', $request->quantity);

        // Redirect to payment instruction with order number
        return redirect()->route('payment-instruction', ['order' => $order->order_number])
            ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }
}
