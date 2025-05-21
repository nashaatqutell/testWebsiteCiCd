<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('role_has_permissions')->truncate();
        DB::table('permissions')->truncate();
        Schema::enableForeignKeyConstraints();
        // create permissions
        $this->createPermissions();
        $superAdminRole = Role::first();
        $superAdminRole->syncPermissions(Permission::all()->pluck('id')->toArray());
    }

    protected function createPermissions()
    {
        $items = [
            'users',
            'roles',
            "blogs",
            "employees",
            "countries",
            "testimonials",
            "partners",
            "galleries",
            "offers",
            "abouts",
            "sliders",
            "staticPages",
            "seo",
            "works",
            "heroSection",
            "contacts",
            "fags",
            "profiles",
            "settings",
            "pages",
            "services",
            "newsLetters",
            "categories",
            "jobs",
            "financials"
        ];
        foreach ($items as $item) {
            permission::create(['name' => "show_$item"  , 'type' => $item , 'guard_name' => 'web']);
            permission::create(['name' => "create_$item", 'type' => $item , 'guard_name' => 'web']);
            permission::create(['name' => "update_$item", 'type' => $item , 'guard_name' => 'web']);
            permission::create(['name' => "delete_$item", 'type' => $item , 'guard_name' => 'web']);
            permission::create(['name' => "active_$item", 'type' => $item , 'guard_name' => 'web']);
        }
    }
}
