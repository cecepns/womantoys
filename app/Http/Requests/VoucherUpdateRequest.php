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

        $rules = [
            'code' => 'required|string|max:50|unique:vouchers,code,' . $voucher->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date|after_or_equal:today',
            'expires_at' => 'nullable|date|after:starts_at',
            'is_active' => 'boolean',
        ];

        // Jika voucher belum digunakan, tambahkan validasi untuk type dan value
        if (!$hasBeenUsed) {
            $rules['type'] = 'required|in:percentage,fixed_amount,free_shipping';
            $rules['value'] = 'required|numeric|min:0';
        } else {
            // Jika sudah digunakan, type dan value tidak boleh diubah
            $rules['type'] = 'prohibited';
            $rules['value'] = 'prohibited';
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
            'type.prohibited' => 'Jenis diskon tidak dapat diubah karena voucher sudah pernah digunakan.',
            'value.required' => 'Nilai diskon wajib diisi.',
            'value.numeric' => 'Nilai diskon harus berupa angka.',
            'value.min' => 'Nilai diskon minimal 0.',
            'value.prohibited' => 'Nilai diskon tidak dapat diubah karena voucher sudah pernah digunakan.',
            'min_purchase.numeric' => 'Minimum pembelian harus berupa angka.',
            'min_purchase.min' => 'Minimum pembelian minimal 0.',
            'max_discount.numeric' => 'Maksimal diskon harus berupa angka.',
            'max_discount.min' => 'Maksimal diskon minimal 0.',
            'usage_limit.integer' => 'Batas penggunaan harus berupa angka bulat.',
            'usage_limit.min' => 'Batas penggunaan minimal 1.',
            'starts_at.date' => 'Tanggal mulai harus berupa tanggal yang valid.',
            'expires_at.date' => 'Tanggal berakhir harus berupa tanggal yang valid.',
            'expires_at.after' => 'Tanggal berakhir harus setelah tanggal mulai.',
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

            // Hanya validasi nilai diskon jika voucher belum digunakan
            if (!$hasBeenUsed) {
                $type = $this->input('type');
                $value = $this->input('value');

                if ($type === 'percentage') {
                    if ($value < 1 || $value > 100) {
                        $validator->errors()->add('value', 'Nilai diskon persentase harus antara 1% - 100%');
                    }
                } elseif ($type === 'fixed_amount') {
                    if ($value < 100) {
                        $validator->errors()->add('value', 'Nilai diskon nominal minimal Rp100');
                    }
                } elseif ($type === 'free_shipping') {
                    if ($value < 100) {
                        $validator->errors()->add('value', 'Nilai diskon nominal minimal Rp100');
                    }
                }
            }
        });
    }
}
