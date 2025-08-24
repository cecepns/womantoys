<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarouselSlide;

class CarouselSlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample carousel slides
        CarouselSlide::create([
            'image_path' => 'carousel/slide1.jpg',
            'title' => 'Discover Your Pleasure',
            'description' => 'Premium collection of adult toys for enhanced intimacy and unforgettable experiences. Explore our curated selection.',
            'cta_text' => 'View Collection',
            'cta_link' => '/catalog',
            'order' => 1,
        ]);

        CarouselSlide::create([
            'image_path' => 'carousel/slide2.jpg',
            'title' => 'Premium Quality Products',
            'description' => 'Curated selection of high-quality intimate products designed for maximum satisfaction and safety.',
            'cta_text' => 'Shop Premium',
            'cta_link' => '/catalog?category=premium',
            'order' => 2,
        ]);

        CarouselSlide::create([
            'image_path' => 'carousel/slide3.jpg',
            'title' => 'Special Offers & Discounts',
            'description' => 'Limited time offers on selected products. Don\'t miss out on these amazing deals!',
            'cta_text' => 'Shop Now',
            'cta_link' => '/catalog?sale=true',
            'order' => 3,
        ]);

        CarouselSlide::create([
            'image_path' => 'carousel/slide4.jpg',
            'title' => 'Discreet & Secure Shopping',
            'description' => 'Your privacy is our priority. 100% discreet packaging and secure transactions guaranteed.',
            'cta_text' => 'Learn More',
            'cta_link' => '/about/privacy',
            'order' => 4,
        ]);
    }
}
