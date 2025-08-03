<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ExportProductionDatabase extends Command
{
    protected $signature = 'db:export-production {--file= : Custom filename for export}';
    
    protected $description = 'Export production-ready database with structure and essential data';

    public function handle()
    {
        $this->info('🗄️ CREATING PRODUCTION DATABASE EXPORT');
        $this->info('=====================================');
        $this->newLine();

        // Create exports directory if it doesn't exist
        if (!File::exists('database/exports')) {
            File::makeDirectory('database/exports', 0755, true);
        }

        $timestamp = date('Y_m_d_H_i_s');
        $filename = $this->option('file') ?: "production_database_{$timestamp}.sql";
        $exportFile = "database/exports/{$filename}";

        try {
            // Start building SQL export
            $sql = "-- ============================================\n";
            $sql .= "-- DESA KARANGREJO - PRODUCTION DATABASE DUMP\n";
            $sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
            $sql .= "-- Laravel Version: " . app()->version() . "\n";
            $sql .= "-- ============================================\n\n";
            
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n";
            $sql .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
            $sql .= "SET AUTOCOMMIT = 0;\n";
            $sql .= "START TRANSACTION;\n";
            $sql .= "SET time_zone = \"+00:00\";\n\n";
            
            // Get all tables
            $tables = DB::select('SHOW TABLES');
            $databaseName = DB::getDatabaseName();
            $tableKey = "Tables_in_{$databaseName}";
            
            foreach ($tables as $table) {
                $tableName = $table->$tableKey;
                
                $this->info("📋 Exporting table: {$tableName}");
                
                // Get table structure
                $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`")[0];
                $sql .= "-- --------------------------------------------------------\n";
                $sql .= "-- Table structure for table `{$tableName}`\n";
                $sql .= "-- --------------------------------------------------------\n\n";
                $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
                $sql .= $createTable->{'Create Table'} . ";\n\n";
                
                // Export data for specific tables only
                $dataToExport = [
                    'users', 'categories', 'pages', 'settings', 
                    'village_data', 'roles', 'permissions', 
                    'model_has_roles', 'model_has_permissions', 'role_has_permissions'
                ];
                
                if (in_array($tableName, $dataToExport)) {
                    $sql .= "-- --------------------------------------------------------\n";
                    $sql .= "-- Dumping data for table `{$tableName}`\n";
                    $sql .= "-- --------------------------------------------------------\n\n";
                    
                    $rows = DB::table($tableName)->get();
                    
                    if ($rows->count() > 0) {
                        $columns = array_keys((array)$rows->first());
                        $sql .= "INSERT INTO `{$tableName}` (`" . implode('`, `', $columns) . "`) VALUES\n";
                        
                        $values = [];
                        foreach ($rows as $row) {
                            $rowData = (array)$row;
                            $escapedValues = [];
                            
                            foreach ($rowData as $value) {
                                if (is_null($value)) {
                                    $escapedValues[] = 'NULL';
                                } else {
                                    $escapedValues[] = "'" . addslashes($value) . "'";
                                }
                            }
                            
                            $values[] = '(' . implode(', ', $escapedValues) . ')';
                        }
                        
                        $sql .= implode(",\n", $values) . ";\n\n";
                    }
                }
            }
            
            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
            $sql .= "COMMIT;\n";
            
            // Write to file
            File::put($exportFile, $sql);
            
            $this->newLine();
            $this->info('✅ Database exported successfully!');
            $this->info("📁 File: {$exportFile}");
            $this->info('📊 Size: ' . $this->formatBytes(File::size($exportFile)));
            
            $this->newLine();
            $this->info('🎉 Production database ready for deployment!');
            $this->info('📝 Admin login: admin@desakarangrejo.id / Admin123!');
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }
    }

    private function formatBytes($size, $precision = 2) {
        $base = log($size, 1024);
        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}
