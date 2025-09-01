<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
{
    /**
     * ANCHOR: Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * ANCHOR: Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'code' => 'required|string|max:50|unique:vouchers,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed_amount,free_shipping',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date|after_or_equal:today',
            'expires_at' => 'nullable|date|after:starts_at',
            'is_active' => 'boolean',
        ];

        // Jika ini adalah update request, ubah unique rule untuk code
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $voucherId = $this->route('voucher')->id;
            $rules['code'] = 'required|string|max:50|unique:vouchers,code,' . $voucherId;
        }

        return $rules;
    }

    /**
     * ANCHOR: Get custom messages for validator errors.
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
            'starts_at.date' => 'Tanggal mulai harus berupa tanggal yang valid.',
            'starts_at.after_or_equal' => 'Tanggal mulai harus sama dengan atau setelah hari ini.',
            'expires_at.date' => 'Tanggal berakhir harus berupa tanggal yang valid.',
            'expires_at.after' => 'Tanggal berakhir harus setelah tanggal mulai.',
        ];
    }

    /**
     * ANCHOR: Configure the validator instance with custom validation logic.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $type = $this->input('type');
            $value = $this->input('value');

            // Validate percentage type (1-100%)
            if ($type === 'percentage') {
                if ($value < 1 || $value > 100) {
                    $validator->errors()->add('value', 'Nilai diskon persentase harus antara 1% - 100%');
                }
            } 
            // Validate fixed amount type (min Rp100)
            elseif ($type === 'fixed_amount') {
                if ($value < 100) {
                    $validator->errors()->add('value', 'Nilai diskon nominal minimal Rp100');
                }
            } 
            // Validate free shipping type (min Rp100)
            elseif ($type === 'free_shipping') {
                if ($value < 100) {
                    $validator->errors()->add('value', 'Nilai diskon nominal minimal Rp100');
                }
            }
        });
    }
}
