<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\VoucherUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    /**
     * Display a listing of the vouchers.
     */
    public function index(Request $request)
    {
        $query = Voucher::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by period
        if ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month);
                    break;
                case 'expired':
                    $query->where('expires_at', '<', now());
                    break;
            }
        }

        $vouchers = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // Statistics for dashboard
        $statistics = [
            'total' => Voucher::count(),
            'active' => Voucher::active()->count(),
            'expired' => Voucher::where('expires_at', '<', now())->count(),
            'total_discount' => VoucherUsage::sum('discount_amount'),
        ];

        return view('admin.vouchers.index', compact('vouchers', 'statistics'));
    }

    /**
     * Show the form for creating a new voucher.
     */
    public function create()
    {
        return view('admin.vouchers.create');
    }

    /**
     * Store a newly created voucher in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:vouchers,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed_amount,free_shipping',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date|after_or_equal:now',
            'expires_at' => 'nullable|date|after:starts_at',
            'is_active' => 'boolean',
            'first_time_only' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $data = $validator->validated();
        
        // Convert to uppercase for code
        $data['code'] = strtoupper($data['code']);
        
        // Set defaults
        $data['is_active'] = $request->has('is_active');
        $data['first_time_only'] = $request->has('first_time_only');
        $data['min_purchase'] = $data['min_purchase'] ?? 0;

        Voucher::create($data);

        return redirect()->route('admin.vouchers.index')
                        ->with('success', 'Voucher berhasil dibuat!');
    }

    /**
     * Display the specified voucher.
     */
    public function show(Voucher $voucher)
    {
        $voucher->load('voucherUsages.order');
        
        $statistics = [
            'total_used' => $voucher->voucherUsages->count(),
            'total_discount_given' => $voucher->voucherUsages->sum('discount_amount'),
            'remaining_usage' => $voucher->usage_limit ? ($voucher->usage_limit - $voucher->used_count) : 'Unlimited',
        ];

        return view('admin.vouchers.show', compact('voucher', 'statistics'));
    }

    /**
     * Show the form for editing the specified voucher.
     */
    public function edit(Voucher $voucher)
    {
        return view('admin.vouchers.edit', compact('voucher'));
    }

    /**
     * Update the specified voucher in storage.
     */
    public function update(Request $request, Voucher $voucher)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:vouchers,code,' . $voucher->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed_amount,free_shipping',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'is_active' => 'boolean',
            'first_time_only' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $data = $validator->validated();
        
        // Convert to uppercase for code
        $data['code'] = strtoupper($data['code']);
        
        // Set defaults
        $data['is_active'] = $request->has('is_active');
        $data['first_time_only'] = $request->has('first_time_only');
        $data['min_purchase'] = $data['min_purchase'] ?? 0;

        $voucher->update($data);

        return redirect()->route('admin.vouchers.index')
                        ->with('success', 'Voucher berhasil diperbarui!');
    }

    /**
     * Remove the specified voucher from storage.
     */
    public function destroy(Voucher $voucher)
    {
        // Check if voucher has been used
        if ($voucher->voucherUsages()->exists()) {
            return redirect()->back()
                           ->with('error', 'Voucher tidak dapat dihapus karena sudah pernah digunakan.');
        }

        $voucher->delete();

        return redirect()->route('admin.vouchers.index')
                        ->with('success', 'Voucher berhasil dihapus!');
    }

    /**
     * Toggle voucher status.
     */
    public function toggleStatus(Voucher $voucher)
    {
        $voucher->update(['is_active' => !$voucher->is_active]);

        $status = $voucher->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()
                        ->with('success', "Voucher berhasil {$status}!");
    }

    /**
     * Generate random voucher code.
     */
    public function generateCode()
    {
        return response()->json(['code' => Voucher::generateCode()]);
    }

    /**
     * Bulk actions for vouchers.
     */
    public function bulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:activate,deactivate,delete',
            'voucher_ids' => 'required|array',
            'voucher_ids.*' => 'exists:vouchers,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator);
        }

        $vouchers = Voucher::whereIn('id', $request->voucher_ids);

        switch ($request->action) {
            case 'activate':
                $vouchers->update(['is_active' => true]);
                $message = 'Voucher yang dipilih berhasil diaktifkan!';
                break;
            case 'deactivate':
                $vouchers->update(['is_active' => false]);
                $message = 'Voucher yang dipilih berhasil dinonaktifkan!';
                break;
            case 'delete':
                // Check if any voucher has been used
                $usedVouchers = $vouchers->whereHas('voucherUsages')->count();
                if ($usedVouchers > 0) {
                    return redirect()->back()
                                   ->with('error', 'Beberapa voucher tidak dapat dihapus karena sudah pernah digunakan.');
                }
                $vouchers->delete();
                $message = 'Voucher yang dipilih berhasil dihapus!';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Export vouchers to Excel.
     */
    public function export()
    {
        // This would typically use a package like Laravel Excel
        // For now, we'll just redirect back
        return redirect()->back()
                        ->with('info', 'Fitur export akan segera tersedia.');
    }

    /**
     * Validate voucher code for checkout.
     */
    public function validateVoucher(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
            'cart_total' => 'required|numeric|min:0',
            'customer_email' => 'nullable|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'valid' => false,
                'message' => 'Data tidak valid.'
            ]);
        }

        $voucher = Voucher::where('code', strtoupper($request->code))->first();

        if (!$voucher) {
            return response()->json([
                'valid' => false,
                'message' => 'Kode voucher tidak ditemukan.'
            ]);
        }

        $cart = [['total' => $request->cart_total]];
        $validation = $voucher->validateForUse($cart, $request->customer_email);

        if (!$validation['valid']) {
            return response()->json($validation);
        }

        $discount = $voucher->calculateDiscount($request->cart_total);

        return response()->json([
            'valid' => true,
            'voucher' => [
                'id' => $voucher->id,
                'code' => $voucher->code,
                'name' => $voucher->name,
                'type' => $voucher->type,
                'discount_amount' => $discount,
                'formatted_discount' => 'Rp ' . number_format($discount, 0, ',', '.'),
            ]
        ]);
    }
}

