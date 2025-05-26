<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\AccessLevel;
use App\Models\Access;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $list = $this->defaultPermissions();
        $admin = Role::create(['name' => 'admin']);
        $client = Role::create(['name' => 'client']);

        foreach($list as $key => $permissions) {
            $group = AccessLevel::create(['name' => $key]);
            
            foreach($permissions as $permission) {
                $permission = Access::create([
                    'name' => $permission,
                    'permission_group_id' => $group->id,
                ]);
                $admin->givePermissionTo($permission);
            }
        }

        $client_perms = Access::whereNotIn('name', [
            'create-user',
            'delete-user',
            'delete-account',
            'edit-transaction',
            'add-cms-page'
        ])->get();
        $client->syncPermissions($client_perms);
    }

    private function defaultPermissions(): array {
        return [
            'user' => [
                'create-user',
                'edit-user',
                'delete-user'
            ],
            'account' => [
                'create-account',
                'view-account',
                'delete-account'
            ],
            'transactions' => [
                'add-transaction',
                'edit-transaction'
            ],
        ];
    }
}
