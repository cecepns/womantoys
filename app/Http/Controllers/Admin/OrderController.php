<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of orders with statistics and filters.
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $status = $request->get('status');
        $search = $request->get('search');
        
        // Build the query
        $query = Order::with(['orderItems.product'])
            ->orderBy('created_at', 'desc');
        
        // Apply status filter
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }
        
        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }
        
        // Paginate results
        $orders = $query->paginate(10)->withQueryString();
        
        // Calculate statistics
        $statistics = $this->getOrderStatistics();
        
        // Get available statuses for filter dropdown
        $statuses = [
            'all' => 'Semua',
            Order::STATUS_PENDING_PAYMENT => 'Menunggu Pembayaran',
            Order::STATUS_PAID => 'Sudah Dibayar',
            Order::STATUS_PROCESSING => 'Sedang Diproses',
            Order::STATUS_SHIPPED => 'Dikirim',
            Order::STATUS_DELIVERED => 'Diterima',
            Order::STATUS_CANCELLED => 'Dibatalkan',
        ];
        
        return view('admin.orders.index', compact('orders', 'statistics', 'statuses', 'status', 'search'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Load relationships
        $order->load(['orderItems.product']);
        
        // Calculate subtotal
        $subtotal = $order->orderItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        
        return view('admin.orders.show', compact('order', 'subtotal'));
    }

    /**
     * Update the status of the specified order.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', [
                Order::STATUS_PENDING_PAYMENT,
                Order::STATUS_PAID,
                Order::STATUS_PROCESSING,
                Order::STATUS_SHIPPED,
                Order::STATUS_DELIVERED,
                Order::STATUS_CANCELLED,
            ]),
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Update the order status
        $order->update(['status' => $newStatus]);

        // Log status change (optional: you can create a separate order_logs table)
        \Log::info("Order {$order->order_number} status changed from {$oldStatus} to {$newStatus} by admin");

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Get order statistics for dashboard.
     */
    private function getOrderStatistics()
    {
        return [
            'total' => Order::count(),
            'pending_payment' => Order::where('status', Order::STATUS_PENDING_PAYMENT)->count(),
            'paid' => Order::where('status', Order::STATUS_PAID)->count(),
            'processing' => Order::where('status', Order::STATUS_PROCESSING)->count(),
            'shipped' => Order::where('status', Order::STATUS_SHIPPED)->count(),
            'delivered' => Order::where('status', Order::STATUS_DELIVERED)->count(),
            'cancelled' => Order::where('status', Order::STATUS_CANCELLED)->count(),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'this_month_revenue' => Order::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->whereIn('status', [Order::STATUS_PAID, Order::STATUS_PROCESSING, Order::STATUS_SHIPPED, Order::STATUS_DELIVERED])
                ->sum('total_amount'),
        ];
    }

    /**
     * Export orders to CSV.
     */
    public function export(Request $request)
    {
        $status = $request->get('status');
        $search = $request->get('search');
        
        $query = Order::with(['orderItems.product']);
        
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }
        
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }
        
        $orders = $query->get();
        
        $filename = 'orders_export_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'No. Pesanan',
                'Nama Pelanggan', 
                'Email',
                'Telepon',
                'Alamat Pengiriman',
                'Metode Pengiriman',
                'Biaya Pengiriman',
                'Total Pembayaran',
                'Status',
                'Tanggal Pesanan',
                'Items'
            ]);
            
            foreach ($orders as $order) {
                $items = $order->orderItems->map(function($item) {
                    return $item->product_name . ' (Qty: ' . $item->quantity . ', Price: Rp ' . number_format($item->price, 0, ',', '.') . ')';
                })->implode('; ');
                
                fputcsv($file, [
                    $order->order_number,
                    $order->customer_name,
                    $order->customer_email,
                    $order->customer_phone,
                    $order->shipping_address,
                    $order->shipping_method,
                    'Rp ' . number_format($order->shipping_cost, 0, ',', '.'),
                    'Rp ' . number_format($order->total_amount, 0, ',', '.'),
                    $this->getStatusLabel($order->status),
                    $order->created_at->format('d/m/Y H:i'),
                    $items
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get human readable status label.
     */
    private function getStatusLabel($status)
    {
        $labels = [
            Order::STATUS_PENDING_PAYMENT => 'Menunggu Pembayaran',
            Order::STATUS_PAID => 'Sudah Dibayar',
            Order::STATUS_PROCESSING => 'Sedang Diproses',
            Order::STATUS_SHIPPED => 'Dikirim',
            Order::STATUS_DELIVERED => 'Diterima',
            Order::STATUS_CANCELLED => 'Dibatalkan',
        ];

        return $labels[$status] ?? $status;
    }

    /**
     * Send confirmation email to customer.
     */
    public function sendConfirmationEmail(Order $order)
    {
        // TODO: Implement email sending logic
        // You can use Laravel Mail here
        
        return redirect()->back()->with('success', 'Email konfirmasi berhasil dikirim ke pelanggan.');
    }

    /**
     * Send WhatsApp message to customer.
     */
    public function sendWhatsAppMessage(Order $order)
    {
        // TODO: Implement WhatsApp API integration
        // You can use a service like Twilio or local WhatsApp Business API
        
        return redirect()->back()->with('success', 'Pesan WhatsApp berhasil dikirim ke pelanggan.');
    }

    /**
     * Generate and download order invoice.
     */
    public function downloadInvoice(Order $order)
    {
        // TODO: Implement PDF invoice generation
        // You can use libraries like DomPDF or TCPDF
        
        return redirect()->back()->with('info', 'Fitur download invoice akan segera tersedia.');
    }
}
