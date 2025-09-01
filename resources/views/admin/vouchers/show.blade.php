@extends('admin.layouts.app')

@section('title', 'Detail Voucher')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Voucher: {{ $voucher->code }}</h1>
        <div>
            <a href="{{ route('admin.vouchers.edit', $voucher) }}" class="btn btn-warning btn-sm mr-2">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit
            </a>
            <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Voucher Information Card -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Voucher</h6>
                    <span class="badge {{ str_replace(['bg-', 'text-'], ['badge-', ''], $voucher->status_badge_class) }} badge-lg">
                        {{ $voucher->status_label }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold">Kode:</td>
                                    <td>{{ $voucher->code }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Nama:</td>
                                    <td>{{ $voucher->name }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Jenis:</td>
                                    <td>
                                        <span class="badge badge-info">{{ $voucher->type_label }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Nilai:</td>
                                    <td>{{ $voucher->formatted_value }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Min. Pembelian:</td>
                                    <td>
                                        @if($voucher->min_purchase > 0)
                                            Rp {{ number_format($voucher->min_purchase, 0, ',', '.') }}
                                        @else
                                            <em>Tidak ada</em>
                                        @endif
                                    </td>
                                </tr>
                                @if($voucher->type === 'percentage' && $voucher->max_discount)
                                <tr>
                                    <td class="font-weight-bold">Maks. Diskon:</td>
                                    <td>Rp {{ number_format($voucher->max_discount, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold">Batas Penggunaan:</td>
                                    <td>
                                        @if($voucher->usage_limit)
                                            {{ $voucher->usage_limit }} kali
                                        @else
                                            <em>Tidak terbatas</em>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Sudah Digunakan:</td>
                                    <td>{{ $voucher->used_count }} kali</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Mulai Berlaku:</td>
                                    <td>
                                        @if($voucher->starts_at)
                                            {{ $voucher->starts_at->format('d/m/Y H:i') }}
                                        @else
                                            <em>Segera</em>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Berakhir:</td>
                                    <td>
                                        @if($voucher->expires_at)
                                            {{ $voucher->expires_at->format('d/m/Y H:i') }}
                                        @else
                                            <em>Tidak pernah</em>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Pelanggan Baru:</td>
                                    <td>
                                        @if($voucher->first_time_only)
                                            <span class="badge badge-warning">Ya</span>
                                        @else
                                            <span class="badge badge-secondary">Tidak</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Dibuat:</td>
                                    <td>{{ $voucher->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($voucher->description)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="font-weight-bold">Deskripsi:</h6>
                            <p class="text-muted">{{ $voucher->description }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Usage History -->
            @if($voucher->voucherUsages->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Penggunaan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Order</th>
                                    <th>Email Customer</th>
                                    <th>Diskon</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($voucher->voucherUsages as $usage)
                                <tr>
                                    <td>{{ $usage->used_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $usage->order) }}" class="text-primary">
                                            {{ $usage->order->order_number }}
                                        </a>
                                    </td>
                                    <td>{{ $usage->customer_email }}</td>
                                    <td>{{ $usage->formatted_discount_amount }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Statistics and Actions -->
        <div class="col-lg-4">
            <!-- Statistics Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-3">
                        <div class="col-6">
                            <div class="border-right">
                                <h4 class="font-weight-bold text-primary">{{ $statistics['total_used'] }}</h4>
                                <small class="text-muted">Total Digunakan</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="font-weight-bold text-success">{{ $statistics['remaining_usage'] }}</h4>
                            <small class="text-muted">Sisa Kuota</small>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <h5 class="font-weight-bold text-info mb-0">{{ $statistics['total_discount_given'] ? 'Rp ' . number_format($statistics['total_discount_given'], 0, ',', '.') : 'Rp 0' }}</h5>
                        <small class="text-muted">Total Diskon Diberikan</small>
                    </div>

                    @if($voucher->usage_limit)
                    <div class="mt-3">
                        <small class="text-muted">Progress Penggunaan:</small>
                        <div class="progress mt-1">
                            @php
                                $percentage = ($voucher->used_count / $voucher->usage_limit) * 100;
                                $progressClass = $percentage < 50 ? 'bg-success' : ($percentage < 80 ? 'bg-warning' : 'bg-danger');
                            @endphp
                            <div class="progress-bar {{ $progressClass }}" role="progressbar" 
                                 style="width: {{ $percentage }}%" 
                                 aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                {{ number_format($percentage, 1) }}%
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Voucher Preview -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Preview Voucher</h6>
                </div>
                <div class="card-body">
                    <div class="voucher-preview border rounded p-3 bg-light text-center">
                        <div class="voucher-icon mb-2">
                            <i class="fas fa-ticket-alt fa-3x text-primary"></i>
                        </div>
                        <h5 class="voucher-code font-weight-bold text-uppercase">{{ $voucher->code }}</h5>
                        <p class="voucher-name mb-2">{{ $voucher->name }}</p>
                        @if($voucher->description)
                        <p class="voucher-description text-muted small">{{ $voucher->description }}</p>
                        @endif
                        <div class="voucher-value">
                            <span class="badge badge-success p-2">{{ $voucher->formatted_value }}</span>
                        </div>
                        <div class="voucher-conditions mt-2">
                            <small class="text-muted">
                                @php
                                    $conditions = [];
                                    if($voucher->min_purchase) {
                                        $conditions[] = 'Min. belanja Rp ' . number_format($voucher->min_purchase, 0, ',', '.');
                                    }
                                    if($voucher->type === 'percentage' && $voucher->max_discount) {
                                        $conditions[] = 'Maks. diskon Rp ' . number_format($voucher->max_discount, 0, ',', '.');
                                    }
                                    if($voucher->expires_at) {
                                        $conditions[] = 'Berlaku sampai ' . $voucher->expires_at->format('d/m/Y');
                                    }
                                @endphp
                                {{ implode(' • ', $conditions) ?: 'Tidak ada syarat khusus' }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.vouchers.edit', $voucher) }}" class="btn btn-warning btn-block mb-2">
                            <i class="fas fa-edit"></i> Edit Voucher
                        </a>
                        
                        <form method="POST" action="{{ route('admin.vouchers.toggle-status', $voucher) }}" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-{{ $voucher->is_active ? 'secondary' : 'success' }} btn-block">
                                <i class="fas fa-{{ $voucher->is_active ? 'times' : 'check' }}"></i> 
                                {{ $voucher->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>

                        @if($voucher->voucherUsages->count() === 0)
                        <form method="POST" action="{{ route('admin.vouchers.destroy', $voucher) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus voucher ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="fas fa-trash"></i> Hapus Voucher
                            </button>
                        </form>
                        @else
                        <button type="button" class="btn btn-danger btn-block" disabled title="Voucher sudah pernah digunakan">
                            <i class="fas fa-trash"></i> Voucher Sudah Digunakan
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            @if($voucher->expires_at && $voucher->expires_at->lt(now()))
            <!-- Expired Warning -->
            <div class="card shadow mb-4 border-danger">
                <div class="card-header py-3 bg-danger">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-exclamation-triangle"></i> Voucher Expired
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">Voucher ini sudah kadaluarsa pada {{ $voucher->expires_at->format('d/m/Y H:i') }}. 
                    Voucher tidak dapat digunakan lagi oleh pelanggan.</p>
                </div>
            </div>
            @endif

            @if($voucher->usage_limit && $voucher->used_count >= $voucher->usage_limit)
            <!-- Usage Limit Reached Warning -->
            <div class="card shadow mb-4 border-warning">
                <div class="card-header py-3 bg-warning">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-exclamation-triangle"></i> Kuota Habis
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">Voucher ini sudah mencapai batas maksimal penggunaan ({{ $voucher->usage_limit }} kali). 
                    Voucher tidak dapat digunakan lagi oleh pelanggan.</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@if(session('success'))
<script>
    // Show success message if redirected from edit/toggle action
    setTimeout(function() {
        alert('{{ session("success") }}');
    }, 100);
</script>
@endif
@endsection
