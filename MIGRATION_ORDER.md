# Urutan File Migrasi - Womantoys Project

## Urutan yang Sudah Diperbaiki

### 1. Tabel Dasar (2025_08_23_12xxxx)
```
2025_08_23_122348_create_admins_table.php
2025_08_23_122648_create_categories_table.php
2025_08_23_123203_create_products_table.php
2025_08_23_123530_create_orders_table.php
2025_08_23_123915_create_order_items_table.php
2025_08_23_124730_create_carousel_slides_table.php
2025_08_23_125048_create_product_images_table.php
2025_08_23_134950_create_sessions_table.php
```

### 2. Tabel Voucher (2025_08_23_13xxxx)
```
2025_08_23_130000_create_vouchers_table.php
2025_08_23_130100_create_voucher_usages_table.php
2025_08_23_130200_add_voucher_fields_to_orders_table.php
2025_08_23_130300_remove_first_time_only_from_vouchers_table.php
2025_08_23_130400_add_voucher_code_to_orders_table.php
2025_08_23_130500_add_missing_fields_to_orders_table.php
```

### 3. Tabel Tambahan (2025_08_24+)
```
2025_08_24_003756_create_bank_accounts_table.php
2025_08_24_032931_make_image_path_nullable_in_carousel_slides_table.php
2025_08_24_065827_add_status_and_stock_to_products_table.php
2025_08_25_232927_make_main_image_nullable_in_products_table.php
2025_08_26_144115_add_cover_image_to_categories_table.php
2025_08_27_144310_add_weight_to_products_table.php
2025_08_28_000000_create_settings_table.php
```

### 4. Modifikasi Lanjutan (2025_08_30+)
```
2025_08_30_115650_add_is_featured_to_products_table.php
2025_08_30_130454_create_main_categories_table.php
2025_08_30_130511_add_main_category_id_to_categories_table.php
2025_08_30_131843_make_main_category_id_required_in_categories_table.php
2025_08_30_161519_add_foreign_key_constraints_to_order_items.php
```

### 5. Tabel Sistem Laravel
```
0001_01_01_000001_create_cache_table.php
0001_01_01_000002_create_jobs_table.php
```

## Penjelasan Perbaikan

### Masalah yang Ditemukan:
1. **File `create_all_tables.php`** - Dihapus karena tidak berguna
2. **Timestamp tidak konsisten** - File voucher memiliki timestamp 2025_01_30 yang seharusnya 2025_08_23
3. **Urutan logis salah** - Beberapa modifikasi tabel dibuat setelah tabel yang bergantung padanya

### Perbaikan yang Dilakukan:
1. ✅ Menghapus file `create_all_tables.php`
2. ✅ Mengubah timestamp file voucher dari 2025_01_30 menjadi 2025_08_23_13xxxx
3. ✅ Mengubah timestamp file modifikasi orders dari 2025_09_02 menjadi 2025_08_23_13xxxx
4. ✅ Memastikan urutan logis: tabel dasar → tabel voucher → modifikasi tabel

### Urutan Logis yang Benar:
1. **Tabel Dasar** - admins, categories, products, orders, order_items, dll
2. **Tabel Voucher** - vouchers, voucher_usages, modifikasi orders untuk voucher
3. **Tabel Tambahan** - bank_accounts, settings, main_categories
4. **Modifikasi Lanjutan** - foreign keys, additional fields, constraints

## Catatan Penting

- **JANGAN UPDATE SKEMA DATABASE** - Hanya perbaiki urutan file migrasi
- Semua file migrasi sudah memiliki konten yang benar
- Urutan timestamp sekarang konsisten dan logis
- File dapat dijalankan secara berurutan tanpa konflik dependensi
