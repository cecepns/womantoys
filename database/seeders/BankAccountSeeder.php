<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BankAccount;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if bank accounts already exist
        if (BankAccount::count() === 0) {
            BankAccount::create([
                'bank_name' => 'Bank Central Asia (BCA)',
                'account_holder_name' => 'WomanToys Store',
                'account_number' => '1234567890',
                'is_active' => true,
            ]);

            BankAccount::create([
                'bank_name' => 'Bank Mandiri',
                'account_holder_name' => 'WomanToys Store',
                'account_number' => '0987654321',
                'is_active' => true,
            ]);

            BankAccount::create([
                'bank_name' => 'Bank Rakyat Indonesia (BRI)',
                'account_holder_name' => 'WomanToys Store',
                'account_number' => '1122334455',
                'is_active' => true,
            ]);
        }
    }
}
