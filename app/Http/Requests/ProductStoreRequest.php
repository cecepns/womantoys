<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'specifications' => 'required|string',
            'care_instructions' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'weight' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,draft,out_of_stock',
            'is_featured' => 'nullable|boolean',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB
            'gallery_images' => 'nullable|array|max:10', // Max 10 images
            'gallery_images.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4', // Support images and videos
            'variants_json' => 'nullable|json',
            'variant_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama produk wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'short_description.required' => 'Deskripsi singkat wajib diisi.',
            'short_description.max' => 'Deskripsi singkat maksimal 500 karakter.',
            'description.required' => 'Deskripsi wajib diisi.',
            'specifications.required' => 'Spesifikasi wajib diisi.',
            'care_instructions.required' => 'Instruksi perawatan wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh negatif.',
            'discount_price.numeric' => 'Harga diskon harus berupa angka.',
            'discount_price.lt' => 'Harga diskon harus lebih kecil dari harga normal.',
            'stock.required' => 'Stok wajib diisi.',
            'stock.integer' => 'Stok harus berupa angka bulat.',
            'stock.min' => 'Stok tidak boleh negatif.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
            'main_image.required' => 'Gambar utama wajib diupload.',
            'main_image.image' => 'File harus berupa gambar.',
            'main_image.mimes' => 'Format gambar harus JPEG, PNG, JPG, atau GIF.',
            'main_image.max' => 'Ukuran gambar utama maksimal 5MB.',
            'gallery_images.array' => 'Format galeri gambar tidak valid.',
            'gallery_images.max' => 'Maksimal 10 gambar galeri.',
            'gallery_images.*.file' => 'File galeri harus berupa gambar atau video.',
            'gallery_images.*.mimes' => 'Format file galeri harus JPEG, PNG, JPG, GIF, atau MP4.',
            'variants_json.json' => 'Format data variant tidak valid.',
            'variant_images.*.image' => 'File variant harus berupa gambar.',
            'variant_images.*.mimes' => 'Format gambar variant harus JPEG, PNG, JPG, atau GIF.',
            'variant_images.*.max' => 'Ukuran gambar variant maksimal 2MB.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validate total file size
            $this->validateTotalFileSize($validator);

            // Validate disk space
            $this->validateDiskSpace($validator);

            // Validate variants JSON structure
            $this->validateVariantsJson($validator);
        });
    }

    /**
     * ANCHOR: Validate total file size to prevent memory issues
     */
    private function validateTotalFileSize($validator)
    {
        // Skip validation for gallery images as they now support videos with no size limit
        $totalSize = 0;
        $maxTotalSize = 50 * 1024 * 1024; // 50MB total for main image and variant images only

        if ($this->hasFile('main_image')) {
            $totalSize += $this->file('main_image')->getSize();
        }

        if ($this->hasFile('variant_images')) {
            foreach ($this->file('variant_images') as $image) {
                if ($image) {
                    $totalSize += $image->getSize();
                }
            }
        }

        if ($totalSize > $maxTotalSize) {
            $validator->errors()->add(
                'files',
                'Total ukuran gambar utama dan variant tidak boleh melebihi 50MB. Saat ini: ' . round($totalSize / 1024 / 1024, 2) . 'MB'
            );
        }
    }

    /**
     * ANCHOR: Validate available disk space
     */
    private function validateDiskSpace($validator)
    {
        $storagePath = storage_path('app/public');
        
        if (!is_dir($storagePath)) {
            return; // Skip if directory doesn't exist yet
        }

        $availableSpace = @disk_free_space($storagePath);
        
        if ($availableSpace === false) {
            return; // Cannot determine, skip check
        }

        $requiredSpace = 100 * 1024 * 1024; // Require at least 100MB free

        if ($this->hasFile('main_image')) {
            $requiredSpace += $this->file('main_image')->getSize();
        }

        if ($this->hasFile('gallery_images')) {
            foreach ($this->file('gallery_images') as $image) {
                $requiredSpace += $image->getSize();
            }
        }

        if ($availableSpace < $requiredSpace) {
            $validator->errors()->add(
                'disk_space',
                'Ruang penyimpanan tidak cukup. Silakan hubungi administrator.'
            );
        }
    }

    /**
     * ANCHOR: Validate variants JSON structure and data
     */
    private function validateVariantsJson($validator)
    {
        if (!$this->filled('variants_json')) {
            return;
        }

        $variants = json_decode($this->variants_json, true);

        // Check JSON decode error
        if (json_last_error() !== JSON_ERROR_NONE) {
            $validator->errors()->add(
                'variants_json',
                'Format JSON variant tidak valid: ' . json_last_error_msg()
            );
            return;
        }

        if (!is_array($variants)) {
            $validator->errors()->add(
                'variants_json',
                'Variant harus berupa array.'
            );
            return;
        }

        // Validate each variant
        foreach ($variants as $index => $variant) {
            $variantNum = $index + 1;

            if (empty($variant['name'])) {
                $validator->errors()->add(
                    "variants_json.{$index}.name",
                    "Variant #{$variantNum}: Nama wajib diisi."
                );
            }

            if (!isset($variant['price']) || !is_numeric($variant['price'])) {
                $validator->errors()->add(
                    "variants_json.{$index}.price",
                    "Variant #{$variantNum}: Harga tidak valid."
                );
            } elseif ($variant['price'] <= 0) {
                $validator->errors()->add(
                    "variants_json.{$index}.price",
                    "Variant #{$variantNum}: Harga harus lebih dari 0."
                );
            }

            if (!isset($variant['stock']) || !is_numeric($variant['stock'])) {
                $validator->errors()->add(
                    "variants_json.{$index}.stock",
                    "Variant #{$variantNum}: Stok tidak valid."
                );
            } elseif ($variant['stock'] < 0) {
                $validator->errors()->add(
                    "variants_json.{$index}.stock",
                    "Variant #{$variantNum}: Stok tidak boleh negatif."
                );
            }

            // Validate discount price if provided
            if (isset($variant['discount_price']) && $variant['discount_price'] !== null) {
                if (!is_numeric($variant['discount_price'])) {
                    $validator->errors()->add(
                        "variants_json.{$index}.discount_price",
                        "Variant #{$variantNum}: Harga diskon tidak valid."
                    );
                } elseif ($variant['discount_price'] >= $variant['price']) {
                    $validator->errors()->add(
                        "variants_json.{$index}.discount_price",
                        "Variant #{$variantNum}: Harga diskon harus lebih kecil dari harga normal."
                    );
                }
            }
        }
    }
}

