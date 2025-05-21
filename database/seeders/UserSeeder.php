<?php

namespace Database\Seeders;

use App\Enums\User\RoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::query()->firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $superAdminRole->syncPermissions(Permission::all()->pluck('id')->toArray());
        $superAdminUser = User::factory()->create([
            'name' => 'qutell',
            'email' => 'admin@qutell.com',
            "phone" => '0512345678',
            'role' => RoleEnum::Admin->value,
            'password' => bcrypt('password'),
        ]);
        $superAdminUser->assignRole($superAdminRole);
    }
}
