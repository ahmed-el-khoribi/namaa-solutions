<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;

class AppBootSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Ahmed Reda',
            'email' => 'admin@mail.com',
            'password' => bcrypt('123456')
        ]);

        $role = Role::create(['name' => 'Super Admin']);

        \Artisan::call('app:sync-permissions');

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $admin->assignRole($role);

        // User
        $user = User::create([
            'name' => 'Normal User',
            'email' => 'normal@mail.com',
            'password' => bcrypt('123456')
        ]);

        $role = Role::create(['name' => 'Normal User']);

        $permissions = Permission::insert([
            ['name' => 'manage_own_articles', 'guard_name' => 'web'],
            ['name' => 'add_comments', 'guard_name' => 'web'],
        ]);

        $role->syncPermissions(Permission::whereIn('name', ['manage_own_articles', 'add_comments'])->pluck('id'));

        $user->assignRole($role);
    }
}
