@extends('admin.layouts.app')

@section('title', 'Edit Voucher')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Voucher: {{ $voucher->code }}</h1>
        <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Voucher</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.vouchers.update', $voucher) }}">
                        @csrf
                        @method('PUT')
                        
                        <!-- Kode Voucher -->
                        <div class="form-group row">
                            <label for="code" class="col-sm-3 col-form-label">Kode Voucher <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                       id="code" name="code" value="{{ old('code', $voucher->code) }}" 
                                       placeholder="Masukkan kode voucher" style="text-transform: uppercase;">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Kode harus unik dan akan digunakan pelanggan</small>
                            </div>
                        </div>

                        <!-- Nama Voucher -->
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Nama Voucher <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $voucher->name) }}" 
                                       placeholder="Masukkan nama voucher">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="form-group row">
                            <label for="description" class="col-sm-3 col-form-label">Deskripsi</label>
                            <div class="col-sm-9">
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3" 
                                          placeholder="Masukkan deskripsi voucher">{{ old('description', $voucher->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Jenis Diskon -->
                        <div class="form-group row">
                            <label for="type" class="col-sm-3 col-form-label">Jenis Diskon <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                                    <option value="">Pilih jenis diskon</option>
                                    <option value="percentage" {{ old('type', $voucher->type) == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                                    <option value="fixed_amount" {{ old('type', $voucher->type) == 'fixed_amount' ? 'selected' : '' }}>Nominal (Rp)</option>
                                    <option value="free_shipping" {{ old('type', $voucher->type) == 'free_shipping' ? 'selected' : '' }}>Gratis Ongkir</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Nilai Diskon -->
                        <div class="form-group row">
                            <label for="value" class="col-sm-3 col-form-label">Nilai Diskon <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="number" class="form-control @error('value') is-invalid @enderror" 
                                           id="value" name="value" value="{{ old('value', $voucher->value) }}" 
                                           placeholder="0" step="0.01" min="0">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="value-suffix">%</span>
                                    </div>
                                </div>
                                @error('value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted" id="value-help">Masukkan nilai persentase (contoh: 50 untuk 50%)</small>
                            </div>
                        </div>

                        <!-- Minimum Pembelian -->
                        <div class="form-group row">
                            <label for="min_purchase" class="col-sm-3 col-form-label">Minimum Pembelian</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" class="form-control @error('min_purchase') is-invalid @enderror" 
                                           id="min_purchase" name="min_purchase" value="{{ old('min_purchase', $voucher->min_purchase) }}" 
                                           placeholder="0" min="0">
                                </div>
                                @error('min_purchase')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Kosongkan jika tidak ada minimum pembelian</small>
                            </div>
                        </div>

                        <!-- Maksimal Diskon -->
                        <div class="form-group row" id="max-discount-group" style="display: none;">
                            <label for="max_discount" class="col-sm-3 col-form-label">Maksimal Diskon</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" class="form-control @error('max_discount') is-invalid @enderror" 
                                           id="max_discount" name="max_discount" value="{{ old('max_discount', $voucher->max_discount) }}" 
                                           placeholder="0" min="0">
                                </div>
                                @error('max_discount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Kosongkan jika tidak ada batasan maksimal diskon</small>
                            </div>
                        </div>

                        <!-- Batas Penggunaan -->
                        <div class="form-group row">
                            <label for="usage_limit" class="col-sm-3 col-form-label">Batas Penggunaan</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control @error('usage_limit') is-invalid @enderror" 
                                       id="usage_limit" name="usage_limit" value="{{ old('usage_limit', $voucher->usage_limit) }}" 
                                       placeholder="0" min="1">
                                @error('usage_limit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Kosongkan untuk penggunaan tidak terbatas. 
                                    @if($voucher->used_count > 0)
                                        <strong>Sudah digunakan: {{ $voucher->used_count }} kali</strong>
                                    @endif
                                </small>
                            </div>
                        </div>

                        <!-- Tanggal Mulai -->
                        <div class="form-group row">
                            <label for="starts_at" class="col-sm-3 col-form-label">Tanggal Mulai</label>
                            <div class="col-sm-9">
                                <input type="datetime-local" class="form-control @error('starts_at') is-invalid @enderror" 
                                       id="starts_at" name="starts_at" value="{{ old('starts_at', $voucher->starts_at ? $voucher->starts_at->format('Y-m-d\TH:i') : '') }}">
                                @error('starts_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Kosongkan untuk berlaku segera</small>
                            </div>
                        </div>

                        <!-- Tanggal Berakhir -->
                        <div class="form-group row">
                            <label for="expires_at" class="col-sm-3 col-form-label">Tanggal Berakhir</label>
                            <div class="col-sm-9">
                                <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror" 
                                       id="expires_at" name="expires_at" value="{{ old('expires_at', $voucher->expires_at ? $voucher->expires_at->format('Y-m-d\TH:i') : '') }}">
                                @error('expires_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Kosongkan untuk voucher permanen</small>
                            </div>
                        </div>

                        <!-- Checkbox Options -->
                        <div class="form-group row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                           {{ old('is_active', $voucher->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Voucher Aktif
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="first_time_only" name="first_time_only" value="1" 
                                           {{ old('first_time_only', $voucher->first_time_only) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="first_time_only">
                                        Hanya untuk pelanggan baru
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="form-group row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary mr-2">
                                    <i class="fas fa-save"></i> Update Voucher
                                </button>
                                <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Voucher Stats Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Voucher</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-right">
                                <h5 class="font-weight-bold text-primary">{{ $voucher->used_count }}</h5>
                                <small class="text-muted">Kali Digunakan</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h5 class="font-weight-bold text-success">
                                @if($voucher->usage_limit)
                                    {{ $voucher->usage_limit - $voucher->used_count }}
                                @else
                                    ∞
                                @endif
                            </h5>
                            <small class="text-muted">Sisa Kuota</small>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <p class="mb-1"><strong>Status:</strong> 
                            <span class="badge {{ str_replace(['bg-', 'text-'], ['badge-', ''], $voucher->status_badge_class) }}">
                                {{ $voucher->status_label }}
                            </span>
                        </p>
                        <p class="mb-0"><strong>Dibuat:</strong> {{ $voucher->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Preview Voucher</h6>
                </div>
                <div class="card-body">
                    <div class="voucher-preview border rounded p-3 bg-light text-center">
                        <div class="voucher-icon mb-2">
                            <i class="fas fa-ticket-alt fa-3x text-primary"></i>
                        </div>
                        <h5 class="voucher-code font-weight-bold text-uppercase" id="preview-code">{{ $voucher->code }}</h5>
                        <p class="voucher-name mb-2" id="preview-name">{{ $voucher->name }}</p>
                        <p class="voucher-description text-muted small" id="preview-description">{{ $voucher->description }}</p>
                        <div class="voucher-value">
                            <span class="badge badge-success p-2" id="preview-value">{{ $voucher->formatted_value }}</span>
                        </div>
                        <div class="voucher-conditions mt-2">
                            <small class="text-muted" id="preview-conditions">
                                @php
                                    $conditions = [];
                                    if($voucher->min_purchase) {
                                        $conditions[] = 'Min. belanja Rp ' . number_format($voucher->min_purchase, 0, ',', '.');
                                    }
                                    if($voucher->type === 'percentage' && $voucher->max_discount) {
                                        $conditions[] = 'Maks. diskon Rp ' . number_format($voucher->max_discount, 0, ',', '.');
                                    }
                                @endphp
                                {{ implode(' • ', $conditions) ?: 'Tidak ada syarat khusus' }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            @if($voucher->used_count > 0)
            <!-- Warning Card -->
            <div class="card shadow mb-4 border-warning">
                <div class="card-header py-3 bg-warning">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-exclamation-triangle"></i> Peringatan
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">Voucher ini sudah digunakan <strong>{{ $voucher->used_count }} kali</strong>. 
                    Perubahan pada jenis diskon dan nilai mungkin akan mempengaruhi perhitungan order yang sudah ada.</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update value suffix and help text based on type
    document.getElementById('type').addEventListener('change', function() {
        const valueSuffix = document.getElementById('value-suffix');
        const valueHelp = document.getElementById('value-help');
        const maxDiscountGroup = document.getElementById('max-discount-group');
        const valueInput = document.getElementById('value');

        switch(this.value) {
            case 'percentage':
                valueSuffix.textContent = '%';
                valueHelp.textContent = 'Masukkan nilai persentase (contoh: 50 untuk 50%)';
                maxDiscountGroup.style.display = 'flex';
                valueInput.max = '100';
                break;
            case 'fixed_amount':
                valueSuffix.textContent = 'Rp';
                valueHelp.textContent = 'Masukkan nominal diskon dalam rupiah';
                maxDiscountGroup.style.display = 'none';
                valueInput.max = '';
                break;
            case 'free_shipping':
                valueSuffix.textContent = '';
                valueHelp.textContent = 'Nilai akan diabaikan untuk gratis ongkir';
                maxDiscountGroup.style.display = 'none';
                valueInput.max = '';
                break;
            default:
                valueSuffix.textContent = '%';
                valueHelp.textContent = 'Pilih jenis diskon terlebih dahulu';
                maxDiscountGroup.style.display = 'none';
                valueInput.max = '';
        }
        updatePreview();
    });

    // Update preview when form values change
    function updatePreview() {
        const code = document.getElementById('code').value || 'KODE VOUCHER';
        const name = document.getElementById('name').value || 'Nama Voucher';
        const description = document.getElementById('description').value || 'Deskripsi voucher akan tampil di sini';
        const type = document.getElementById('type').value;
        const value = document.getElementById('value').value;
        const minPurchase = document.getElementById('min_purchase').value;
        const maxDiscount = document.getElementById('max_discount').value;

        document.getElementById('preview-code').textContent = code;
        document.getElementById('preview-name').textContent = name;
        document.getElementById('preview-description').textContent = description;

        // Format value display
        let valueText = 'Diskon akan tampil di sini';
        if (type && value) {
            switch(type) {
                case 'percentage':
                    valueText = value + '% OFF';
                    break;
                case 'fixed_amount':
                    valueText = 'Rp ' + parseInt(value).toLocaleString('id-ID');
                    break;
                case 'free_shipping':
                    valueText = 'GRATIS ONGKIR';
                    break;
            }
        }
        document.getElementById('preview-value').textContent = valueText;

        // Format conditions
        let conditions = [];
        if (minPurchase) {
            conditions.push('Min. belanja Rp ' + parseInt(minPurchase).toLocaleString('id-ID'));
        }
        if (type === 'percentage' && maxDiscount) {
            conditions.push('Maks. diskon Rp ' + parseInt(maxDiscount).toLocaleString('id-ID'));
        }
        
        const conditionsText = conditions.length > 0 ? conditions.join(' • ') : 'Tidak ada syarat khusus';
        document.getElementById('preview-conditions').textContent = conditionsText;
    }

    // Add event listeners for preview updates
    ['code', 'name', 'description', 'value', 'min_purchase', 'max_discount'].forEach(id => {
        document.getElementById(id).addEventListener('input', updatePreview);
    });

    // Format code to uppercase
    document.getElementById('code').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });

    // Initialize form based on current voucher type
    document.getElementById('type').dispatchEvent(new Event('change'));
});
</script>
@endpush
@endsection
