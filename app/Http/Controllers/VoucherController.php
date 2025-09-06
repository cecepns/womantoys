<?php

namespace App\Http\Controllers;

use App\Helpers\SettingHelper;
use App\Models\Voucher;
use App\Models\VoucherUsage;
use App\Http\Requests\VoucherRequest;
use App\Http\Requests\VoucherUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    /**
     * ANCHOR: Display a listing of the vouchers.
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

        // Filter by usage status
        if ($request->filled('usage')) {
            switch ($request->usage) {
                case 'used':
                    $query->used();
                    break;
                case 'unused':
                    $query->unused();
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
            'used' => Voucher::used()->count(),
        ];

        return view('admin.vouchers.index', compact('vouchers', 'statistics'));
    }

    /**
     * ANCHOR: Show the form for creating a new voucher.
     */
    public function create()
    {
        return view('admin.vouchers.create');
    }

    /**
     * ANCHOR: Store a newly created voucher in storage.
     */
    public function store(VoucherRequest $request)
    {
        $data = $request->validated();

        // Convert to uppercase for code
        $data['code'] = strtoupper($data['code']);

        // Set defaults
        $data['is_active'] = $request->has('is_active');
        $data['min_purchase'] = $data['min_purchase'] ?? 0;

        Voucher::create($data);

        notify()->success('Voucher berhasil dibuat!', 'Berhasil');
        return redirect()->route('admin.vouchers.index');
    }

    /**
     * ANCHOR: Display the specified voucher.
     */
    public function show(Voucher $voucher)
    {
        $voucher->load('voucherUsages.order');

        $statistics = [
            'total_used' => $voucher->getUsageCount(),
            'total_discount_given' => $voucher->voucherUsages->sum('discount_amount'),
            'remaining_usage' => $voucher->usage_limit ? ($voucher->usage_limit - $voucher->getUsageCount()) : '-',
        ];

        return view('admin.vouchers.show', compact('voucher', 'statistics'));
    }

    /**
     * ANCHOR: Show the form for editing the specified voucher.
     */
    public function edit(Voucher $voucher)
    {
        return view('admin.vouchers.edit', compact('voucher'));
    }

    /**
     * ANCHOR: Update the specified voucher in storage.
     */
    public function update(VoucherUpdateRequest $request, Voucher $voucher)
    {
        $data = $request->validated();

        // Convert to uppercase for code
        $data['code'] = strtoupper($data['code']);

        // Set defaults
        $data['is_active'] = $request->has('is_active');
        $data['min_purchase'] = $data['min_purchase'] ?? 0;

        // If voucher has been used, preserve original type and value
        if ($voucher->hasBeenUsed()) {
            unset($data['type'], $data['value']);
        }

        $voucher->update($data);

        notify()->success('Voucher berhasil diperbarui!', 'Berhasil');
        return redirect()->route('admin.vouchers.index');
    }

    /**
     * ANCHOR: Remove the specified voucher from storage.
     */
    public function destroy(Voucher $voucher)
    {
        // Check if voucher has been used
        if ($voucher->hasBeenUsed()) {
            notify()->error('Voucher tidak dapat dihapus karena sudah pernah digunakan.', 'Gagal');
            return redirect()->back();
        }

        $voucher->delete();

        notify()->success('Voucher berhasil dihapus!', 'Berhasil');
        return redirect()->route('admin.vouchers.index');
    }

    /**
     * ANCHOR: Toggle voucher status.
     */
    public function toggleStatus(Voucher $voucher)
    {
        $voucher->update(['is_active' => !$voucher->is_active]);

        $status = $voucher->is_active ? 'diaktifkan' : 'dinonaktifkan';

        notify()->success("Voucher berhasil {$status}!", 'Berhasil');
        return redirect()->back();
    }

    /**
     * ANCHOR: Generate random voucher code.
     */
    public function generateCode()
    {
        return response()->json(['code' => Voucher::generateCode()]);
    }

    /**
     * ANCHOR: Bulk actions for vouchers.
     */
    public function bulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:activate,deactivate,delete',
            'voucher_ids' => 'required|array',
            'voucher_ids.*' => 'exists:vouchers,id',
        ]);

        if ($validator->fails()) {
            notify()->error('Data yang dimasukkan tidak valid.', 'Gagal');
            return redirect()->back()->withErrors($validator);
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
                $usedVouchers = $vouchers->where('used_count', '>', 0)->count();
                if ($usedVouchers > 0) {
                    notify()->error('Beberapa voucher tidak dapat dihapus karena sudah pernah digunakan.', 'Gagal');
                    return redirect()->back();
                }
                $vouchers->delete();
                $message = 'Voucher yang dipilih berhasil dihapus!';
                break;
        }

        notify()->success($message, 'Berhasil');
        return redirect()->back();
    }

    /**
     * ANCHOR: Export vouchers to Excel.
     */
    public function export()
    {
        // This would typically use a package like Laravel Excel
        // For now, we'll just redirect back
        notify()->info('Fitur export akan segera tersedia.', 'Informasi');
        return redirect()->back();
    }

    /**
     * ANCHOR:  Validate voucher code for checkout.
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
                'formatted_discount' => SettingHelper::formatCurrency($discount),
            ]
        ]);
    }
}
