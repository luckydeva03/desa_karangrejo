<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DatabaseExport extends Command
{
    protected $signature = 'db:export {filename?}';
    protected $description = 'Export database to SQL file';

    public function handle()
    {
        $filename = $this->argument('filename') ?? 'desa_karangrejo_production_ready_' . date('Y_m_d_His') . '.sql';
        $exportPath = database_path('exports/' . $filename);
        
        // Ensure exports directory exists
        File::ensureDirectoryExists(database_path('exports'));
        
        $this->info('🚀 Starting database export...');
        
        try {
            // Get database configuration
            $database = config('database.connections.mysql.database');
            $host = config('database.connections.mysql.host');
            $port = config('database.connections.mysql.port');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            
            // Build mysqldump command
            $command = sprintf(
                'mysqldump -h%s -P%s -u%s %s %s --routines --triggers --single-transaction --set-gtid-purged=OFF > "%s"',
                $host,
                $port,
                $username,
                $password ? "-p{$password}" : '',
                $database,
                $exportPath
            );
            
            // Try to find mysqldump in common locations
            $mysqldumpPaths = [
                'C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysqldump.exe',
                'C:\xampp\mysql\bin\mysqldump.exe',
                'mysqldump' // system PATH
            ];
            
            $mysqldumpPath = null;
            foreach ($mysqldumpPaths as $path) {
                if (file_exists($path) || $path === 'mysqldump') {
                    $mysqldumpPath = $path;
                    break;
                }
            }
            
            if (!$mysqldumpPath) {
                $this->error('❌ mysqldump not found in common locations');
                return 1;
            }
            
            $fullCommand = sprintf(
                '"%s" -h%s -P%s -u%s %s %s --routines --triggers --single-transaction --set-gtid-purged=OFF',
                $mysqldumpPath,
                $host,
                $port,
                $username,
                $password ? "-p{$password}" : '',
                $database
            );
            
            $this->info("Executing: {$fullCommand}");
            
            // Execute command and capture output
            $output = shell_exec($fullCommand);
            
            if ($output) {
                File::put($exportPath, $output);
                $this->info("✅ Database exported successfully to: {$exportPath}");
                $this->info("📊 File size: " . File::size($exportPath) . " bytes");
                return 0;
            } else {
                $this->error('❌ Failed to export database');
                return 1;
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Error: " . $e->getMessage());
            return 1;
        }
    }
}
