<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Get current month and previous month for comparison
        $currentMonth = Carbon::now()->startOfMonth();
        $previousMonth = Carbon::now()->subMonth()->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // Total orders
        $totalOrders = Order::count();
        $currentMonthOrders = Order::where('created_at', '>=', $currentMonth)->count();
        $previousMonthOrders = Order::whereBetween('created_at', [$previousMonth, $previousMonthEnd])->count();
        $orderGrowth = $previousMonthOrders > 0 ? 
            round((($currentMonthOrders - $previousMonthOrders) / $previousMonthOrders) * 100, 1) : 0;

        // Total products
        $totalProducts = Product::count();
        $newProductsThisMonth = Product::where('created_at', '>=', $currentMonth)->count();

        // Revenue calculation - only count completed orders
        $completedStatuses = [
            Order::STATUS_PROCESSING, 
            Order::STATUS_SHIPPED, 
            Order::STATUS_DELIVERED
        ];
        
        $totalRevenue = Order::whereIn('status', $completedStatuses)->sum('total_amount');
        
        $currentMonthRevenue = Order::whereIn('status', $completedStatuses)
            ->where('created_at', '>=', $currentMonth)->sum('total_amount');
        
        $previousMonthRevenue = Order::whereIn('status', $completedStatuses)
            ->whereBetween('created_at', [$previousMonth, $previousMonthEnd])->sum('total_amount');
        
        $revenueGrowth = $previousMonthRevenue > 0 ? 
            round((($currentMonthRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100, 1) : 0;

        // Pending orders - orders that need attention
        $pendingOrders = Order::whereIn('status', [
            Order::STATUS_PENDING_PAYMENT,
            Order::STATUS_PAID
        ])->count();
        
        // Calculate pending orders from yesterday for comparison
        $yesterdayPendingOrders = Order::whereIn('status', [
            Order::STATUS_PENDING_PAYMENT,
            Order::STATUS_PAID
        ])->whereDate('created_at', Carbon::yesterday())->count();
        
        $pendingChange = $pendingOrders - $yesterdayPendingOrders;

        // Additional revenue insights
        $pendingRevenue = Order::whereIn('status', [
            Order::STATUS_PENDING_PAYMENT,
            Order::STATUS_PAID
        ])->sum('total_amount');
        
        $todayRevenue = Order::whereIn('status', $completedStatuses)
            ->whereDate('created_at', Carbon::today())->sum('total_amount');
        
        $thisWeekRevenue = Order::whereIn('status', $completedStatuses)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('total_amount');

        // Order status breakdown
        $orderStatusBreakdown = [
            'pending_payment' => Order::where('status', Order::STATUS_PENDING_PAYMENT)->count(),
            'paid' => Order::where('status', Order::STATUS_PAID)->count(),
            'processing' => Order::where('status', Order::STATUS_PROCESSING)->count(),
            'shipped' => Order::where('status', Order::STATUS_SHIPPED)->count(),
            'delivered' => Order::where('status', Order::STATUS_DELIVERED)->count(),
            'cancelled' => Order::where('status', Order::STATUS_CANCELLED)->count(),
        ];

        // Recent orders
        $recentOrders = Order::with('orderItems.product')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Format revenue for display
        $formattedTotalRevenue = 'Rp ' . number_format($totalRevenue, 0, ',', '.');
        $formattedCurrentMonthRevenue = 'Rp ' . number_format($currentMonthRevenue, 0, ',', '.');

        return view('admin.dashboard', compact(
            'totalOrders',
            'orderGrowth',
            'totalProducts',
            'newProductsThisMonth',
            'formattedTotalRevenue',
            'revenueGrowth',
            'pendingOrders',
            'pendingChange',
            'recentOrders',
            'pendingRevenue',
            'todayRevenue',
            'thisWeekRevenue',
            'orderStatusBreakdown'
        ));
    }

    /**
     * Format currency for display.
     */
    private function formatCurrency($amount)
    {
        if ($amount >= 1000000000) {
            return 'Rp ' . number_format($amount / 1000000000, 1) . 'B';
        } elseif ($amount >= 1000000) {
            return 'Rp ' . number_format($amount / 1000000, 1) . 'M';
        } elseif ($amount >= 1000) {
            return 'Rp ' . number_format($amount / 1000, 1) . 'K';
        } else {
            return 'Rp ' . number_format($amount, 0, ',', '.');
        }
    }
}
