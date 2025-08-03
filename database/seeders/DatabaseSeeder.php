<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Starting database seeding...');
        
        // Run original seeders
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            SettingsSeeder::class,
            PageSeeder::class,
            VillageDataSeeder::class,
            PostSeeder::class,
            AnnouncementSeeder::class,
        ]);
        
        $this->command->info('✅ Database seeding completed!');
        $this->command->info('📝 Default login: thendeand@gmail.com / Karangrejo2025');
    }
}