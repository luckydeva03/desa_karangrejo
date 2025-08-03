<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OptimizeForProduction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:optimize-production';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize application for production environment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Optimizing application for production...');
        
        // Clear all caches first
        $this->info('🧹 Clearing existing caches...');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        $this->call('cache:clear');
        
        // Generate optimized caches
        $this->info('⚡ Generating optimized caches...');
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('view:cache');
        
        // Generate optimized autoloader
        $this->info('📦 Optimizing autoloader...');
        exec('composer dump-autoload --optimize');
        
        // Create storage link if not exists
        if (!file_exists(public_path('storage'))) {
            $this->info('🔗 Creating storage link...');
            $this->call('storage:link');
        }
        
        // Set proper permissions (for Linux/Unix systems)
        if (PHP_OS !== 'WINNT') {
            $this->info('🔐 Setting proper permissions...');
            exec('chmod -R 755 ' . storage_path());
            exec('chmod -R 755 ' . base_path('bootstrap/cache'));
        }
        
        $this->info('✅ Production optimization completed!');
        $this->newLine();
        $this->info('📋 Next steps:');
        $this->line('   1. Verify .env configuration');
        $this->line('   2. Run: php artisan migrate --force');
        $this->line('   3. Test application functionality');
        $this->line('   4. Monitor logs: storage/logs/');
        
        return Command::SUCCESS;
    }
}
