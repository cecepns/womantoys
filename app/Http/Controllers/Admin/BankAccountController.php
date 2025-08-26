<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bankAccounts = BankAccount::orderBy('created_at', 'desc')->get();
        return view('admin.accounts.index', compact('bankAccounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_holder' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ], [
            'bank_name.required' => 'Nama bank wajib diisi.',
            'account_number.required' => 'Nomor rekening wajib diisi.',
            'account_holder.required' => 'Atas nama wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        BankAccount::create([
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_holder_name' => $request->account_holder,
            'is_active' => $request->status === 'active',
        ]);

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Rekening bank berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BankAccount $account)
    {
        return view('admin.accounts.edit', compact('account'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankAccount $account)
    {
        $account->delete();

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Rekening bank berhasil dihapus.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BankAccount $account)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_holder' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ], [
            'bank_name.required' => 'Nama bank wajib diisi.',
            'account_number.required' => 'Nomor rekening wajib diisi.',
            'account_holder.required' => 'Atas nama wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        $account->update([
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_holder_name' => $request->account_holder,
            'is_active' => $request->status === 'active',
        ]);

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Rekening bank berhasil diperbarui.');
    }

}
