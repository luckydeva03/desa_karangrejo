<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ExportDatabase extends Command
{
    protected $signature = 'db:export {--path=database/exports/} {--with-data} {--tables=*}';
    
    protected $description = 'Export database structure and optionally data';

    public function handle()
    {
        $path = $this->option('path');
        $withData = $this->option('with-data');
        $tables = $this->option('tables');
        
        // Create export directory if not exists
        $exportPath = base_path($path);
        if (!File::exists($exportPath)) {
            File::makeDirectory($exportPath, 0755, true);
        }
        
        $timestamp = now()->format('Y_m_d_His');
        $filename = "desa_karangrejo_export_{$timestamp}.sql";
        $fullPath = $exportPath . $filename;
        
        $this->info("Starting database export...");
        
        // Get database connection info
        $connection = config('database.default');
        $database = config("database.connections.{$connection}.database");
        $host = config("database.connections.{$connection}.host");
        $port = config("database.connections.{$connection}.port");
        $username = config("database.connections.{$connection}.username");
        $password = config("database.connections.{$connection}.password");
        
        // Build mysqldump command
        $command = "mysqldump";
        $command .= " --host={$host}";
        $command .= " --port={$port}";
        $command .= " --user={$username}";
        
        if ($password) {
            $command .= " --password={$password}";
        }
        
        $command .= " --single-transaction";
        $command .= " --routines";
        $command .= " --triggers";
        
        if (!$withData) {
            $command .= " --no-data";
        }
        
        $command .= " {$database}";
        
        if (!empty($tables)) {
            $command .= " " . implode(' ', $tables);
        }
        
        $command .= " > \"{$fullPath}\"";
        
        // Execute command
        $result = null;
        $output = [];
        exec($command, $output, $result);
        
        if ($result === 0) {
            $this->info("Database exported successfully to: {$fullPath}");
            $this->info("File size: " . $this->formatBytes(filesize($fullPath)));
        } else {
            $this->error("Export failed. Please check if mysqldump is available in your PATH.");
            $this->line("Command executed: {$command}");
        }
        
        return $result;
    }
    
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
