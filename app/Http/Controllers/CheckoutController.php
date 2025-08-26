<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
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

        if ($product->stock <= 0) {
            return redirect()->route('product-detail', $product->slug)->with('error', 'Stok produk habis.');
        }

        return view('checkout', compact('product'));
    }

    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'fullName' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'shipping' => 'required|in:regular,express',
            'quantity' => 'required|integer|min:1'
        ]);

        // Get product
        $product = Product::findOrFail($request->product_id);
        
        // Validate stock
        if ($product->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Stok tidak mencukupi untuk jumlah yang dipilih.'])->withInput();
        }

        // Calculate costs
        $shippingCost = $request->shipping === 'express' ? 35000 : 20000;
        $subtotal = $product->price * $request->quantity;
        $totalAmount = $subtotal + $shippingCost;

        // Create order
        $order = \App\Models\Order::create([
            'customer_name' => $request->fullName,
            'customer_phone' => $request->phone,
            'customer_email' => $request->email,
            'shipping_address' => $request->address,
            'shipping_method' => $request->shipping,
            'shipping_cost' => $shippingCost,
            'total_amount' => $totalAmount,
        ]);

        // Create order item
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
