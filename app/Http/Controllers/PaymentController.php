<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Show payment instruction page
     */
    public function show(Request $request)
    {
        $orderNumber = $request->query('order');
        
        if (!$orderNumber) {
            return redirect()->route('catalog')->with('error', 'Nomor pesanan tidak ditemukan.');
        }

        // Find order by order number with order items
        $order = Order::with('orderItems')->where('order_number', $orderNumber)->first();
        
        if (!$order) {
            return redirect()->route('catalog')->with('error', 'Pesanan tidak ditemukan.');
        }

        // Check if order is still pending payment
        if (!$order->isPendingPayment()) {
            return redirect()->route('catalog')->with('error', 'Pesanan ini sudah tidak dapat dikonfirmasi pembayarannya.');
        }

        return view('payment-instruction', compact('order'));
    }

    /**
     * Handle payment confirmation with proof upload
     */
    public function confirmPayment(Request $request)
    {
        $orderNumber = $request->input('order_number');
        
        if (!$orderNumber) {
            return back()->with('error', 'Nomor pesanan tidak ditemukan.');
        }

        // Find order
        $order = Order::where('order_number', $orderNumber)->first();
        
        if (!$order) {
            return back()->with('error', 'Pesanan tidak ditemukan.');
        }

        // Check if order is still pending payment
        if (!$order->isPendingPayment()) {
            return back()->with('error', 'Pesanan ini sudah tidak dapat dikonfirmasi pembayarannya.');
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'payment_proof' => 'required|file|mimes:png,jpg,jpeg,pdf|max:10240', // 10MB max
            'notes' => 'nullable|string|max:1000',
        ], [
            'payment_proof.required' => 'Bukti pembayaran harus diunggah.',
            'payment_proof.file' => 'File yang diunggah tidak valid.',
            'payment_proof.mimes' => 'Format file harus PNG, JPG, JPEG, atau PDF.',
            'payment_proof.max' => 'Ukuran file maksimal 10MB.',
            'notes.max' => 'Catatan maksimal 1000 karakter.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Handle file upload
            $file = $request->file('payment_proof');
            $fileName = 'payment_proof_' . $order->order_number . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('payment_proofs', $fileName, 'public');

            // Update order
            $order->update([
                'payment_proof_path' => $filePath,
                'status' => Order::STATUS_PAID,
            ]);

            return redirect()->route('payment-instruction', ['order' => $order->order_number])
                ->with('success', 'Bukti pembayaran berhasil diunggah! Pesanan Anda sedang diproses.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengunggah bukti pembayaran. Silakan coba lagi.')
                ->withInput();
        }
    }
}