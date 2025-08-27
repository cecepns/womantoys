<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have products to work with
        $products = Product::where('status', 'active')->get();
        
        if ($products->isEmpty()) {
            $this->command->warn('No active products found. Please run ProductSeeder first.');
            return;
        }

        $this->command->info('Creating sample orders...');

        // Create various orders with different statuses
        $sampleOrders = [
            [
                'customer_name' => 'Sarah Johnson',
                'customer_phone' => '+62812-3456-7890',
                'customer_email' => 'sarah.johnson@email.com',
                'shipping_address' => "Jl. Sudirman No. 123, RT 001/RW 002\nKelurahan Senayan, Kecamatan Kebayoran Baru\nJakarta Selatan, DKI Jakarta 12190",
                'shipping_method' => 'JNE - REG',
                'shipping_cost' => 15000,
                'status' => Order::STATUS_PENDING_PAYMENT,
                'items' => [
                    ['quantity' => 1],
                    ['quantity' => 1]
                ]
            ],
            [
                'customer_name' => 'Michael Chen',
                'customer_phone' => '+62856-7890-1234',
                'customer_email' => 'michael.chen@email.com',
                'shipping_address' => "Jl. Gatot Subroto No. 456\nKelurahan Setiabudi, Kecamatan Setiabudi\nJakarta Selatan, DKI Jakarta 12930",
                'shipping_method' => 'TIKI - ONS',
                'shipping_cost' => 20000,
                'status' => Order::STATUS_PAID,
                'payment_proof_path' => 'payment_proofs/sample_transfer_1.jpg',
                'items' => [
                    ['quantity' => 2]
                ]
            ],
            [
                'customer_name' => 'Lisa Rodriguez',
                'customer_phone' => '+62821-5678-9012',
                'customer_email' => 'lisa.rodriguez@email.com',
                'shipping_address' => "Jl. Thamrin No. 789\nKelurahan Menteng, Kecamatan Menteng\nJakarta Pusat, DKI Jakarta 10310",
                'shipping_method' => 'JNT - REG',
                'shipping_cost' => 12000,
                'status' => Order::STATUS_PROCESSING,
                'payment_proof_path' => 'payment_proofs/sample_transfer_2.jpg',
                'items' => [
                    ['quantity' => 1],
                    ['quantity' => 2],
                    ['quantity' => 1]
                ]
            ],
            [
                'customer_name' => 'David Kim',
                'customer_phone' => '+62813-9012-3456',
                'customer_email' => 'david.kim@email.com',
                'shipping_address' => "Jl. Kuningan No. 321\nKelurahan Kuningan, Kecamatan Setiabudi\nJakarta Selatan, DKI Jakarta 12950",
                'shipping_method' => 'POS - Kilat',
                'shipping_cost' => 25000,
                'status' => Order::STATUS_SHIPPED,
                'payment_proof_path' => 'payment_proofs/sample_transfer_3.jpg',
                'items' => [
                    ['quantity' => 1]
                ]
            ],
            [
                'customer_name' => 'Amanda Wilson',
                'customer_phone' => '+62822-3456-7890',
                'customer_email' => 'amanda.wilson@email.com',
                'shipping_address' => "Jl. Rasuna Said No. 654\nKelurahan Setiabudi, Kecamatan Setiabudi\nJakarta Selatan, DKI Jakarta 12920",
                'shipping_method' => 'JNE - YES',
                'shipping_cost' => 30000,
                'status' => Order::STATUS_DELIVERED,
                'payment_proof_path' => 'payment_proofs/sample_transfer_4.jpg',
                'items' => [
                    ['quantity' => 2],
                    ['quantity' => 1]
                ]
            ],
            [
                'customer_name' => 'Robert Davis',
                'customer_phone' => '+62814-5678-9012',
                'customer_email' => 'robert.davis@email.com',
                'shipping_address' => "Jl. Senopati No. 987\nKelurahan Senayan, Kecamatan Kebayoran Baru\nJakarta Selatan, DKI Jakarta 12180",
                'shipping_method' => 'TIKI - REG',
                'shipping_cost' => 18000,
                'status' => Order::STATUS_CANCELLED,
                'items' => [
                    ['quantity' => 1]
                ]
            ]
        ];

        DB::transaction(function () use ($sampleOrders, $products) {
            foreach ($sampleOrders as $orderData) {
                // Calculate total from items
                $itemsData = $orderData['items'];
                unset($orderData['items']);
                
                $subtotal = 0;
                $selectedProducts = $products->random(count($itemsData));
                
                foreach ($itemsData as $index => $itemData) {
                    $product = $selectedProducts[$index];
                    $subtotal += $product->price * $itemData['quantity'];
                }
                
                $orderData['total_amount'] = $subtotal + $orderData['shipping_cost'];
                
                // Create order
                $order = Order::create($orderData);
                
                // Create order items
                foreach ($itemsData as $index => $itemData) {
                    $product = $selectedProducts[$index];
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $itemData['quantity'],
                    ]);
                }
                
                $this->command->info("Created order: {$order->order_number} for {$order->customer_name}");
            }
        });

        // Create some additional orders with random data
        $this->command->info('Creating additional random orders...');
        
        $randomCustomers = [
            ['name' => 'Emily Johnson', 'email' => 'emily.j@email.com', 'phone' => '+62815-1111-2222'],
            ['name' => 'James Wilson', 'email' => 'james.w@email.com', 'phone' => '+62816-3333-4444'],
            ['name' => 'Sophie Brown', 'email' => 'sophie.b@email.com', 'phone' => '+62817-5555-6666'],
            ['name' => 'Thomas Garcia', 'email' => 'thomas.g@email.com', 'phone' => '+62818-7777-8888'],
            ['name' => 'Olivia Martinez', 'email' => 'olivia.m@email.com', 'phone' => '+62819-9999-0000'],
        ];

        $shippingMethods = [
            ['method' => 'JNE - REG', 'cost' => 15000],
            ['method' => 'JNE - YES', 'cost' => 30000],
            ['method' => 'TIKI - REG', 'cost' => 18000],
            ['method' => 'TIKI - ONS', 'cost' => 25000],
            ['method' => 'JNT - REG', 'cost' => 12000],
            ['method' => 'POS - Kilat', 'cost' => 22000],
        ];

        $statuses = [
            Order::STATUS_PENDING_PAYMENT,
            Order::STATUS_PAID,
            Order::STATUS_PROCESSING,
            Order::STATUS_SHIPPED,
            Order::STATUS_DELIVERED,
        ];

        DB::transaction(function () use ($randomCustomers, $shippingMethods, $statuses, $products) {
            foreach ($randomCustomers as $customer) {
                $shipping = collect($shippingMethods)->random();
                $status = collect($statuses)->random();
                
                // Random 1-3 items per order
                $itemCount = rand(1, 3);
                $selectedProducts = $products->random($itemCount);
                
                $subtotal = 0;
                foreach ($selectedProducts as $product) {
                    $quantity = rand(1, 2);
                    $subtotal += $product->price * $quantity;
                }
                
                $order = Order::create([
                    'customer_name' => $customer['name'],
                    'customer_phone' => $customer['phone'],
                    'customer_email' => $customer['email'],
                    'shipping_address' => "Jl. Random No. " . rand(100, 999) . "\nKelurahan Random, Kecamatan Random\nJakarta, DKI Jakarta " . rand(10000, 99999),
                    'shipping_method' => $shipping['method'],
                    'shipping_cost' => $shipping['cost'],
                    'total_amount' => $subtotal + $shipping['cost'],
                    'status' => $status,
                    'payment_proof_path' => $status !== Order::STATUS_PENDING_PAYMENT ? 'payment_proofs/sample_transfer_random.jpg' : null,
                ]);
                
                foreach ($selectedProducts as $product) {
                    $quantity = rand(1, 2);
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $quantity,
                    ]);
                }
                
                $this->command->info("Created random order: {$order->order_number} for {$order->customer_name}");
            }
        });

        $this->command->info('Order seeding completed!');
        $this->command->info('Total orders created: ' . Order::count());
    }
}
