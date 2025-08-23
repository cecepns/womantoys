<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# WomanToys - Laravel Application

A Laravel application for WomanToys adult toy store with modern layout using Tailwind CSS.

## Setup yang Telah Dikonfigurasi

### 1. Tailwind CSS
- ✅ Tailwind CSS v4 telah terinstall dan dikonfigurasi
- ✅ File konfigurasi: `tailwind.config.js`
- ✅ PostCSS config: `postcss.config.js`
- ✅ CSS utama: `resources/css/app.css`

### 2. Layout Utama
- ✅ File layout: `resources/views/layouts/app.blade.php`
- ✅ Struktur HTML5 dengan header, main, dan footer
- ✅ Navbar responsif dengan logo "WomanToys"
- ✅ Footer dengan link penting (How to Order, Privacy Policy, Terms & Conditions)
- ✅ Area konten dinamis menggunakan `@yield('content')`

### 3. Halaman Beranda
- ✅ File: `resources/views/welcome.blade.php`
- ✅ Menggunakan layout utama
- ✅ Hero section dengan call-to-action
- ✅ Features section dengan 3 fitur utama (Premium Quality, Safe & Discreet, Enhanced Pleasure)
- ✅ CTA section dengan gradient background

### 4. Komponen Product Card
- ✅ File: `resources/views/components/product-card.blade.php`
- ✅ Kartu produk dengan gambar, nama, dan harga
- ✅ Efek hover dan transisi yang smooth
- ✅ Responsive design

### 5. Halaman Products
- ✅ File: `resources/views/products.blade.php`
- ✅ Grid layout untuk menampilkan product cards
- ✅ Responsive grid system

## Struktur File

```
resources/
├── views/
│   ├── layouts/
│   │   └── app.blade.php          # Layout utama
│   ├── components/
│   │   └── product-card.blade.php # Komponen kartu produk
│   ├── welcome.blade.php          # Halaman beranda
│   └── products.blade.php         # Halaman produk
└── css/
    └── app.css                    # CSS dengan Tailwind
```

## Cara Menjalankan

1. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```

2. **Build assets:**
   ```bash
   npm run build
   ```

3. **Jalankan server:**
   ```bash
   php artisan serve
   ```

4. **Akses aplikasi:**
   ```
   http://localhost:8000
   ```

## Fitur Layout

### Header
- Logo "WomanToys" dengan warna pink
- Navigation links: Collection, About Us, Contact
- Responsive design dengan mobile menu button

### Main Content
- Area dinamis untuk konten halaman
- Menggunakan `@yield('content')` untuk inheritance

### Footer
- Informasi perusahaan
- Link cepat: How to Order, Privacy Policy, Terms & Conditions
- Informasi kontak
- Copyright notice

## Styling

- Menggunakan Tailwind CSS utility classes
- Color scheme: Pink (#ec4899) sebagai primary color
- Responsive design untuk mobile dan desktop
- Modern UI dengan shadows, gradients, dan transitions

## Database Models

Aplikasi ini memiliki beberapa model yang sudah dibuat:
- Admin
- Category
- Product
- ProductImage
- Order
- OrderItem
- CarouselSlide

## Next Steps

Untuk pengembangan selanjutnya, Anda dapat:
1. Membuat halaman-halaman tambahan menggunakan layout yang sama
2. Mengimplementasikan sistem autentikasi
3. Membuat halaman admin untuk mengelola produk
4. Menambahkan fitur keranjang belanja
5. Mengintegrasikan payment gateway
6. Menambahkan fitur review dan rating produk
7. Implementasi sistem pencarian dan filter produk
