<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Voucher;
use App\Models\VoucherUsage;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\Setting;

class CheckoutController extends Controller
{
    /**
     * ANCHOR: Display checkout page - supports both direct and cart modes
     */
    public function index(Request $request)
    {
        $mode = $request->query('mode', 'direct'); // 'direct' or 'cart'
        $originId = (int) Setting::getValue('store_origin_id', 17473);
        
        if ($mode === 'direct') {
            // ========================================
            // FLOW 1: DIRECT CHECKOUT (Single Product)
            // ========================================
            
            // Get product ID, variant ID, and quantity from query parameters
            $productId = $request->query('product');
            $variantId = $request->query('variant');
            $quantity = $request->query('quantity', 1);

            if (!$productId) {
                return redirect()->route('catalog')->with('error', 'Produk tidak ditemukan.');
            }

            // Validate quantity
            $quantity = (int) $quantity;
            if ($quantity < 1) {
                return redirect()->route('product-detail', ['product' => $productId])->with('error', 'Jumlah produk minimal 1.');
            }

            // Load product with relationships
            $product = Product::with(['category', 'images', 'variants'])
                ->where('id', $productId)
                ->where('status', 'active')
                ->first();

            if (!$product) {
                return redirect()->route('catalog')->with('error', 'Produk tidak ditemukan.');
            }

            // Handle variant if provided
            $variant = null;
            $checkoutPrice = $product->final_price;
            $checkoutStock = $product->stock;
            
            if ($variantId) {
                $variant = ProductVariant::where('id', $variantId)
                    ->where('product_id', $product->id)
                    ->where('is_active', true)
                    ->first();

                if (!$variant) {
                    return redirect()->route('product-detail', $product->slug)->with('error', 'Variant tidak ditemukan.');
                }

                // Use variant price and stock
                $checkoutPrice = $variant->final_price;
                $checkoutStock = $variant->stock;
            } else if ($product->hasActiveVariants()) {
                // If product has variants but none selected, redirect back
                return redirect()->route('product-detail', $product->slug)->with('error', 'Silakan pilih variant terlebih dahulu.');
            }

            // Check stock availability
            if ($checkoutStock <= 0) {
                return redirect()->route('product-detail', $product->slug)->with('error', 'Stok produk habis.');
            }

            // Validate quantity against stock
            if ($quantity > $checkoutStock) {
                return redirect()->route('product-detail', $product->slug)->with('error', 'Jumlah yang dipilih melebihi stok tersedia.');
            }

            // Return view untuk DIRECT checkout (single product)
            return view('checkout', [
                'mode' => 'direct',
                'product' => $product,
                'variant' => $variant,
                'checkoutPrice' => $checkoutPrice,
                'checkoutStock' => $checkoutStock,
                'quantity' => $quantity,
                'originId' => $originId
            ]);
            
        } else {
            // ========================================
            // FLOW 2: CART-BASED CHECKOUT (Multiple Products)
            // ========================================
            
            // Return view untuk CART checkout (multiple products)
            // JavaScript akan load cart dari localStorage
            return view('checkout', [
                'mode' => 'cart',
                'originId' => $originId
            ]);
        }
    }

    /**
     * ANCHOR: Process checkout and create order - supports both direct and cart modes
     */
    public function store(Request $request)
    {
        $mode = $request->input('mode', 'direct'); // 'direct' or 'cart'
        
        if ($mode === 'direct') {
            // ========================================
            // FLOW 1: DIRECT CHECKOUT (Single Product)
            // ========================================
            
            // Validate request
            $request->validate([
                'mode' => 'required|in:direct,cart',
                'product_id' => 'required|exists:products,id',
                'variant_id' => 'nullable|exists:product_variants,id',
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

            // Handle variant if provided
            $variant = null;
            $finalPrice = $product->final_price;
            $originalPrice = $product->price;
            $stockToCheck = $product->stock;
            $variantName = null;
            
            if ($request->filled('variant_id')) {
                $variant = ProductVariant::where('id', $request->variant_id)
                    ->where('product_id', $product->id)
                    ->where('is_active', true)
                    ->firstOrFail();
                
                $finalPrice = $variant->final_price;
                $originalPrice = $variant->price;
                $stockToCheck = $variant->stock;
                $variantName = $variant->name;
            }

            // Validate stock availability
            if ($stockToCheck < $request->quantity) {
                return back()->withErrors(['quantity' => 'Stok tidak mencukupi untuk jumlah yang dipilih.'])->withInput();
            }

            // Parse shipping data from format: courier_service_cost
            $shippingData = explode('_', $request->shipping);
            $courier = $shippingData[0] ?? 'unknown';
            $service = $shippingData[1] ?? 'unknown';
            $shippingCost = (int)($shippingData[2] ?? 0);

            // Calculate order costs
            $subtotal = $finalPrice * $request->quantity;
            $discountAmount = 0;
            $voucher = null;

            // Handle voucher if provided
            if ($request->filled('voucher_id') && $request->filled('voucher_code')) {
                $voucher = Voucher::find($request->voucher_id);

                if ($voucher && $voucher->code === $request->voucher_code) {
                    $cart = [['total' => $subtotal]];
                    $validation = $voucher->validateForUse($cart, $request->email);

                    if ($validation['valid']) {
                        if ($voucher->type === 'free_shipping') {
                            $discountAmount = 0;
                            $shippingCost = 0;
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
            if ($totalAmount < 0) {
                $totalAmount = 0;
            }

            // Combine address fields
            $fullAddress = $request->address_location . "\n" . $request->address_detail;

            // Create order record
            $order = Order::create([
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

            // Create order item (single)
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_variant_id' => $variant ? $variant->id : null,
                'variant_name' => $variantName,
                'product_name' => $product->name,
                'price' => $finalPrice,
                'original_price' => $originalPrice,
                'quantity' => $request->quantity,
            ]);

            // Track voucher usage
            if ($voucher) {
                VoucherUsage::create([
                    'voucher_id' => $voucher->id,
                    'order_id' => $order->id,
                    'customer_email' => $request->email,
                    'discount_amount' => $discountAmount,
                ]);
                $voucher->increment('used_count');
            }

            // Update stock
            if ($variant) {
                $variant->decrement('stock', $request->quantity);
            } else {
                $product->decrement('stock', $request->quantity);
            }

            // Redirect to payment instruction
            return redirect()->route('payment-instruction', ['order' => $order->order_number])
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
            
        } else {
            // ========================================
            // FLOW 2: CART-BASED CHECKOUT (Multiple Products)
            // ========================================
            
            // Validate request untuk CART MODE
            $request->validate([
                'mode' => 'required|in:direct,cart',
                'cart_items' => 'required|json',
                'fullName' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'email' => 'required|email|max:255',
                'address_location' => 'required|string|max:255',
                'address_detail' => 'required|string',
                'shipping' => 'required|string',
                'origin_id' => 'required|integer',
                'destination_id' => 'required|integer',
                'voucher_id' => 'nullable|exists:vouchers,id',
                'voucher_code' => 'nullable|string',
                'discount_amount' => 'nullable|numeric|min:0'
            ]);

            // Parse cart items dari JSON
            $cartItems = json_decode($request->input('cart_items'), true);
            
            if (empty($cartItems)) {
                return back()->withErrors(['cart' => 'Keranjang kosong.'])->withInput();
            }

            // Validate semua items & calculate subtotal
            $subtotal = 0;
            $validatedItems = [];
            
            foreach ($cartItems as $itemData) {
                $product = Product::find($itemData['product_id']);
                
                if (!$product) {
                    return back()->withErrors(['cart' => 'Produk tidak ditemukan.'])->withInput();
                }
                
                $variant = null;
                $finalPrice = $product->final_price;
                $originalPrice = $product->price;
                $stockToCheck = $product->stock;
                $variantName = null;
                
                // Handle variant
                if (!empty($itemData['variant_id'])) {
                    $variant = ProductVariant::where('id', $itemData['variant_id'])
                        ->where('product_id', $product->id)
                        ->where('is_active', true)
                        ->first();
                    
                    if (!$variant) {
                        return back()->withErrors(['cart' => "Variant untuk {$product->name} tidak valid."])
                            ->withInput();
                    }
                    
                    $finalPrice = $variant->final_price;
                    $originalPrice = $variant->price;
                    $stockToCheck = $variant->stock;
                    $variantName = $variant->name;
                }
                
                // Validate stock
                if ($stockToCheck < $itemData['quantity']) {
                    $itemName = $product->name . ($variantName ? " - {$variantName}" : '');
                    return back()->withErrors(['cart' => "Stok {$itemName} tidak mencukupi."])
                        ->withInput();
                }
                
                // SECURITY: Recalculate price dari database
                $itemSubtotal = $finalPrice * $itemData['quantity'];
                $subtotal += $itemSubtotal;
                
                // Store validated item
                $validatedItems[] = [
                    'product' => $product,
                    'variant' => $variant,
                    'variantName' => $variantName,
                    'finalPrice' => $finalPrice,
                    'originalPrice' => $originalPrice,
                    'quantity' => $itemData['quantity']
                ];
            }

            // Parse shipping data
            $shippingData = explode('_', $request->shipping);
            $courier = $shippingData[0] ?? 'unknown';
            $service = $shippingData[1] ?? 'unknown';
            $shippingCost = (int)($shippingData[2] ?? 0);

            // Handle voucher
            $discountAmount = 0;
            $voucher = null;
            
            if ($request->filled('voucher_id') && $request->filled('voucher_code')) {
                $voucher = Voucher::find($request->voucher_id);

                if ($voucher && $voucher->code === $request->voucher_code) {
                    $cart = [['total' => $subtotal]];
                    $validation = $voucher->validateForUse($cart, $request->email);

                    if ($validation['valid']) {
                        if ($voucher->type === 'free_shipping') {
                            $discountAmount = 0;
                            $shippingCost = 0;
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
            if ($totalAmount < 0) {
                $totalAmount = 0;
            }

            // Combine address fields
            $fullAddress = $request->address_location . "\n" . $request->address_detail;

            // Create order record
            $order = Order::create([
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

            // Create MULTIPLE order items (LOOP)
            foreach ($validatedItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'product_variant_id' => $item['variant'] ? $item['variant']->id : null,
                    'variant_name' => $item['variantName'],
                    'product_name' => $item['product']->name,
                    'price' => $item['finalPrice'],
                    'original_price' => $item['originalPrice'],
                    'quantity' => $item['quantity'],
                ]);
                
                // Update stock
                if ($item['variant']) {
                    $item['variant']->decrement('stock', $item['quantity']);
                } else {
                    $item['product']->decrement('stock', $item['quantity']);
                }
            }

            // Track voucher usage
            if ($voucher) {
                VoucherUsage::create([
                    'voucher_id' => $voucher->id,
                    'order_id' => $order->id,
                    'customer_email' => $request->email,
                    'discount_amount' => $discountAmount,
                ]);
                $voucher->increment('used_count');
            }

            // Redirect to payment instruction dengan flag untuk clear cart
            return redirect()->route('payment-instruction', ['order' => $order->order_number])
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.')
                ->with('clear_cart', true); // Signal to clear cart
        }
    }
}
