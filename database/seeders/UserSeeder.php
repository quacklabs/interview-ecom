<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Profile;
use App\Models\Account;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admin = User::create([
            'password' => '12345678',
            'email' => 'ad@min.dev',
            'email_verified_at' => Carbon::now(),
            'active' => true,
        ]);
        $admin_role = Role::findByName('admin');
        $admin->assignRole($admin_role);
        $admin->save();
    }
}
