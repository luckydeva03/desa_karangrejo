<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class ExportDatabasePHP extends Command
{
    protected $signature = 'db:export-php {--with-data} {--file=}';
    
    protected $description = 'Export database using PHP (no mysqldump required)';

    public function handle()
    {
        $withData = $this->option('with-data');
        $customFile = $this->option('file');
        
        $timestamp = now()->format('Y_m_d_His');
        $filename = $customFile ?: "desa_karangrejo_export_{$timestamp}.sql";
        $exportPath = database_path('exports');
        
        if (!File::exists($exportPath)) {
            File::makeDirectory($exportPath, 0755, true);
        }
        
        $fullPath = $exportPath . '/' . $filename;
        
        $this->info("Starting PHP-based database export...");
        
        $sql = "-- Database Export for Desa Karangrejo\n";
        $sql .= "-- Generated on: " . now()->format('Y-m-d H:i:s') . "\n";
        $sql .= "-- Laravel Version: " . app()->version() . "\n\n";
        
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";
        
        // Get all tables
        $tables = DB::select('SHOW TABLES');
        $databaseName = config('database.connections.' . config('database.default') . '.database');
        $tableKey = "Tables_in_{$databaseName}";
        
        foreach ($tables as $table) {
            $tableName = $table->$tableKey;
            
            $this->line("Exporting table: {$tableName}");
            
            // Get CREATE TABLE statement
            $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`")[0];
            $sql .= "-- Table structure for `{$tableName}`\n";
            $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            $sql .= $createTable->{'Create Table'} . ";\n\n";
            
            // Export data if requested
            if ($withData) {
                $rows = DB::table($tableName)->get();
                
                if ($rows->count() > 0) {
                    $sql .= "-- Data for table `{$tableName}`\n";
                    $sql .= "INSERT INTO `{$tableName}` VALUES\n";
                    
                    $values = [];
                    foreach ($rows as $row) {
                        $rowData = [];
                        foreach ($row as $value) {
                            if (is_null($value)) {
                                $rowData[] = 'NULL';
                            } else {
                                $rowData[] = "'" . addslashes($value) . "'";
                            }
                        }
                        $values[] = '(' . implode(', ', $rowData) . ')';
                    }
                    
                    $sql .= implode(",\n", $values) . ";\n\n";
                }
            }
        }
        
        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
        
        File::put($fullPath, $sql);
        
        $this->info("Database exported successfully to: {$fullPath}");
        $this->info("File size: " . $this->formatBytes(filesize($fullPath)));
        
        return 0;
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
