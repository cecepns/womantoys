<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Voucher;

class VoucherUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $voucher = $this->route('voucher');
        $hasBeenUsed = $voucher->hasBeenUsed();
        $type = $this->input('type');

        $rules = [
            'code' => 'required|string|max:50|unique:vouchers,code,' . $voucher->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'type' => 'required|in:percentage,fixed_amount,free_shipping',
        ];

        // Hanya validasi value jika bukan free_shipping dan voucher belum digunakan
        if ($type !== 'free_shipping' && !$hasBeenUsed) {
            $rules['value'] = 'required|numeric|min:0';
        } else {
            $rules['value'] = 'nullable|numeric|min:0';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'code.required' => 'Kode voucher wajib diisi.',
            'code.unique' => 'Kode voucher sudah digunakan.',
            'code.max' => 'Kode voucher maksimal 50 karakter.',
            'name.required' => 'Nama voucher wajib diisi.',
            'name.max' => 'Nama voucher maksimal 255 karakter.',
            'type.required' => 'Jenis diskon wajib dipilih.',
            'type.in' => 'Jenis diskon tidak valid.',
            'value.required' => 'Nilai diskon wajib diisi.',
            'value.numeric' => 'Nilai diskon harus berupa angka.',
            'value.min' => 'Nilai diskon minimal 0.',
            'min_purchase.numeric' => 'Minimum pembelian harus berupa angka.',
            'min_purchase.min' => 'Minimum pembelian minimal 0.',
            'max_discount.numeric' => 'Maksimal diskon harus berupa angka.',
            'max_discount.min' => 'Maksimal diskon minimal 0.',
            'usage_limit.integer' => 'Batas penggunaan harus berupa angka bulat.',
            'usage_limit.min' => 'Batas penggunaan minimal 1.',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $voucher = $this->route('voucher');
            $hasBeenUsed = $voucher->hasBeenUsed();
            $type = $this->input('type');
            $startsAt = $this->input('starts_at');
            $expiresAt = $this->input('expires_at');

            // Hanya validasi nilai diskon jika voucher belum digunakan dan bukan free_shipping
            if (!$hasBeenUsed && $type !== 'free_shipping') {
                $value = $this->input('value');

                if ($type === 'percentage') {
                    if ($value < 1 || $value > 100) {
                        $validator->errors()->add('value', 'Nilai diskon persentase harus antara 1% - 100%');
                    }
                } elseif ($type === 'fixed_amount') {
                    if ($value < 100) {
                        $validator->errors()->add('value', 'Nilai diskon nominal minimal Rp100');
                    }
                }
            }

            // Validate date logic: Start date tidak boleh lebih dari end date
            if ($startsAt && $expiresAt) {
                if (strtotime($startsAt) > strtotime($expiresAt)) {
                    $validator->errors()->add('starts_at', 'Tanggal mulai tidak boleh lebih dari tanggal berakhir');
                    $validator->errors()->add('expires_at', 'Tanggal berakhir tidak boleh kurang dari tanggal mulai');
                }
            }
        });
    }
}
