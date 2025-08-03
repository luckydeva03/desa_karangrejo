<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;

class SecurityAudit extends Command
{
    protected $signature = 'security:audit {--fix : Automatically fix some issues}';
    
    protected $description = 'Perform security audit and optionally fix issues';

    public function handle()
    {
        $this->info('🔍 Starting Security Audit...');
        $this->newLine();

        $issues = [];
        $warnings = [];
        $info = [];

        // Check environment
        $this->checkEnvironment($issues, $warnings, $info);
        
        // Check file permissions
        $this->checkFilePermissions($issues, $warnings, $info);
        
        // Check configurations
        $this->checkConfigurations($issues, $warnings, $info);
        
        // Check for common vulnerabilities
        $this->checkVulnerabilities($issues, $warnings, $info);

        // Display results
        $this->displayResults($issues, $warnings, $info);

        return count($issues) === 0 ? 0 : 1;
    }

    private function checkEnvironment(&$issues, &$warnings, &$info)
    {
        $this->info('📋 Checking Environment Configuration...');

        // Check if in production
        if (app()->environment('production')) {
            if (config('app.debug') === true) {
                $issues[] = 'APP_DEBUG is enabled in production';
            } else {
                $info[] = '✓ APP_DEBUG correctly disabled in production';
            }
        }

        // Check APP_KEY
        if (empty(config('app.key'))) {
            $issues[] = 'APP_KEY is not set';
        } else {
            $info[] = '✓ APP_KEY is configured';
        }

        // Check database password
        if (empty(config('database.connections.mysql.password'))) {
            $warnings[] = 'Database password is empty';
        }
    }

    private function checkFilePermissions(&$issues, &$warnings, &$info)
    {
        $this->info('📁 Checking File Permissions...');

        $criticalFiles = [
            '.env' => '600',
            'storage' => '755',
            'bootstrap/cache' => '755',
        ];

        foreach ($criticalFiles as $file => $expectedPerm) {
            $path = base_path($file);
            if (File::exists($path)) {
                $currentPerm = substr(sprintf('%o', fileperms($path)), -3);
                if ($currentPerm !== $expectedPerm) {
                    $warnings[] = "File {$file} has permissions {$currentPerm}, should be {$expectedPerm}";
                } else {
                    $info[] = "✓ {$file} has correct permissions ({$currentPerm})";
                }
            }
        }
    }

    private function checkConfigurations(&$issues, &$warnings, &$info)
    {
        $this->info('⚙️ Checking Security Configurations...');

        // Session configuration
        if (!config('session.encrypt')) {
            $warnings[] = 'Session encryption is disabled';
        } else {
            $info[] = '✓ Session encryption is enabled';
        }

        // Check session lifetime
        $lifetime = config('session.lifetime');
        if ($lifetime > 240) {
            $warnings[] = "Session lifetime is {$lifetime} minutes (consider reducing for better security)";
        } else {
            $info[] = "✓ Session lifetime is reasonable ({$lifetime} minutes)";
        }

        // HTTPS settings
        if (app()->environment('production')) {
            if (!config('session.secure')) {
                $issues[] = 'Secure cookies should be enabled in production';
            }
        }
    }

    private function checkVulnerabilities(&$issues, &$warnings, &$info)
    {
        $this->info('🔒 Checking for Common Vulnerabilities...');

        // Check for unescaped output in Blade templates
        $viewPath = resource_path('views');
        $bladeFiles = File::allFiles($viewPath);
        
        $xssVulnerable = [];
        foreach ($bladeFiles as $file) {
            $content = File::get($file->getPathname());
            if (preg_match('/\{\!\!\s*\$\w+.*?\!\!\}/', $content)) {
                $xssVulnerable[] = str_replace($viewPath . DIRECTORY_SEPARATOR, '', $file->getPathname());
            }
        }

        if (!empty($xssVulnerable)) {
            $warnings[] = 'Potential XSS vulnerabilities found in: ' . implode(', ', $xssVulnerable);
        } else {
            $info[] = '✓ No obvious XSS vulnerabilities detected in Blade templates';
        }

        // Check .htaccess
        $htaccessPath = public_path('.htaccess');
        if (!File::exists($htaccessPath) || File::size($htaccessPath) < 100) {
            $issues[] = 'Missing or incomplete .htaccess file in public directory';
        } else {
            $info[] = '✓ .htaccess file exists and appears configured';
        }
    }

    private function displayResults($issues, $warnings, $info)
    {
        $this->newLine();
        $this->info('📊 Security Audit Results:');
        $this->newLine();

        if (!empty($issues)) {
            $this->error('🚨 CRITICAL ISSUES FOUND:');
            foreach ($issues as $issue) {
                $this->error("  • {$issue}");
            }
            $this->newLine();
        }

        if (!empty($warnings)) {
            $this->warn('⚠️  WARNINGS:');
            foreach ($warnings as $warning) {
                $this->warn("  • {$warning}");
            }
            $this->newLine();
        }

        if (!empty($info)) {
            $this->info('✅ GOOD PRACTICES FOUND:');
            foreach ($info as $item) {
                $this->line("  {$item}");
            }
            $this->newLine();
        }

        // Summary
        $totalIssues = count($issues);
        $totalWarnings = count($warnings);
        
        if ($totalIssues === 0 && $totalWarnings === 0) {
            $this->info('🎉 No critical security issues found!');
        } else {
            $this->error("Found {$totalIssues} critical issues and {$totalWarnings} warnings.");
            $this->info('Please review and fix these issues before deploying to production.');
        }
    }
}
