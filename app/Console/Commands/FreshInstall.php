<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class FreshInstall extends Command
{
    protected $signature = 'app:fresh-install {--seed} {--force}';
    
    protected $description = 'Fresh installation with migrations and optional seeding';

    public function handle()
    {
        $seed = $this->option('seed');
        $force = $this->option('force');
        
        if (!$force && !$this->confirm('This will drop all tables and recreate them. Continue?')) {
            $this->info('Operation cancelled.');
            return 1;
        }
        
        $this->info('🚀 Starting fresh installation...');
        
        // Fresh migrations
        $this->info('📋 Running fresh migrations...');
        Artisan::call('migrate:fresh', ['--force' => true]);
        $this->line(Artisan::output());
        
        if ($seed) {
            $this->info('🌱 Seeding database...');
            Artisan::call('db:seed', ['--force' => true]);
            $this->line(Artisan::output());
        }
        
        // Create storage link
        $this->info('🔗 Creating storage link...');
        try {
            Artisan::call('storage:link');
            $this->line(Artisan::output());
        } catch (\Exception $e) {
            $this->warn('Storage link already exists or failed to create.');
        }
        
        // Clear and cache
        $this->info('🧹 Clearing caches...');
        Artisan::call('optimize:clear');
        
        $this->info('⚡ Optimizing for production...');
        Artisan::call('optimize');
        
        $this->info('✅ Fresh installation completed successfully!');
        
        return 0;
    }
}
