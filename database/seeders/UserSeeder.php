<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles and permissions first
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $userRole = Role::firstOrCreate(['name' => 'user']);
        
        // Create permissions
        $permissions = [
            'view_dashboard',
            'manage_users',
            'manage_posts',
            'manage_pages',
            'manage_categories',
            'manage_settings',
            'manage_announcements',
            'manage_gallery',
            'manage_village_data',
        ];
        
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        
        // Assign all permissions to admin role
        $adminRole->syncPermissions($permissions);
        
        // Create admin user
        $user = User::updateOrCreate(
            ['email' => 'thendeand@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('Karangrejo2025'),
                'status' => 'active',
                'phone' => '081234567890',
                'bio' => 'Administrator sistem website Desa Karangrejo',
                'email_verified_at' => now(),
            ]
        );
        
        // Assign admin role to user
        $user->assignRole('admin');
        
        $this->command->info('✅ Admin user created with roles and permissions');
    }
}