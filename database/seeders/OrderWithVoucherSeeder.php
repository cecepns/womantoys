<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Voucher;
use App\Models\Product;
use App\Models\Category;
use App\Models\MainCategory;

class OrderWithVoucherSeeder extends Seeder
{
    /**
     * ANCHOR: Create test order with voucher for testing voucher display.
     */
    public function run(): void
    {
        // Create main category if not exists
        $mainCategory = MainCategory::firstOrCreate(
            ['name' => 'Main Category Test'],
            ['slug' => 'main-category-test']
        );

        // Create category if not exists
        $category = Category::firstOrCreate(
            ['name' => 'Category Test'],
            [
                'main_category_id' => $mainCategory->id,
                'slug' => 'category-test'
            ]
        );

        // Create product if not exists
        $product = Product::firstOrCreate(
            ['name' => 'Product Test'],
            [
                'slug' => 'product-test',
                'short_description' => 'Test product short description',
                'description' => 'Test product description',
                'specifications' => 'Test specifications',
                'care_instructions' => 'Test care instructions',
                'price' => 100000,
                'main_image' => 'default-product.jpg',
                'category_id' => $category->id
            ]
        );

        // Create voucher if not exists
        $voucher = Voucher::firstOrCreate(
            ['code' => 'TESTVOUCHER'],
            [
                'name' => 'Voucher Test 20%',
                'type' => 'percentage',
                'value' => 20,
                'min_purchase' => 50000,
                'max_discount' => 50000,
                'is_active' => true,
                'usage_limit' => 100,
                'used_count' => 0,
                'starts_at' => now()->subDays(30),
                'expires_at' => now()->addDays(30)
            ]
        );

        // Create order with voucher if not exists
        $order = Order::firstOrCreate(
            ['order_number' => 'ORD20250902001'],
            [
                'confirmation_token' => 'test_token_123',
                'customer_name' => 'Customer Test',
                'customer_phone' => '08123456789',
                'customer_email' => 'customer@test.com',
                'shipping_address' => 'Jl. Test No. 123, Jakarta',
                'shipping_method' => 'JNE Regular',
                'shipping_cost' => 15000,
                'subtotal' => 100000,
                'discount_amount' => 20000, // 20% dari 100000
                'voucher_id' => $voucher->id,
                'voucher_code' => $voucher->code,
                'total_amount' => 95000, // subtotal - discount + shipping
                'status' => 'sudah_dibayar'
            ]
        );

        // Create order item if not exists
        if (!$order->orderItems()->exists()) {
            $order->orderItems()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => 1,
                'price' => 100000
            ]);
        }

        $this->command->info('Test order with voucher created successfully!');
        $this->command->info('Order Number: ' . $order->order_number);
        $this->command->info('Voucher Code: ' . $voucher->code);
    }
}
