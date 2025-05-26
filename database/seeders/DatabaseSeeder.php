<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\WalletSeeder;
use Database\Seeders\BankSeeder;
use Database\Seeders\WithdrawRequestSeeder;
use Database\Seeders\DepositSeeder;
use Database\Seeders\PlanSeeder;
use Database\Seeders\InvestmentSeeder;
use Database\Seeders\PaymentInfoSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(1)->create()
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        
    }
}
