<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckCurrentIp extends Command
{
    protected $signature = 'ip:check';
    protected $description = 'Check current server IP address for whitelisting';

    public function handle()
    {
        $this->info('=== Server IP Information ===');
        $this->newLine();

        // Get server IP
        $serverIp = $_SERVER['SERVER_ADDR'] ?? gethostbyname(gethostname());
        $this->info("Server IP: {$serverIp}");

        // Get local IP
        $localIp = gethostbyname(gethostname());
        $this->info("Local IP: {$localIp}");

        // Get public IP
        try {
            $publicIp = @file_get_contents('https://api.ipify.org');
            if ($publicIp) {
                $this->info("Public IP: {$publicIp}");
            } else {
                $this->warn("Public IP: Unable to fetch");
            }
        } catch (\Exception $e) {
            $this->warn("Public IP: Unable to fetch");
        }

        $this->newLine();
        $this->info('📝 Add these IP ranges to allowed_ip_ranges table:');
        $this->line("   - {$serverIp} (exact match)");

        // Calculate prefix for range
        $parts = explode('.', $localIp);
        if (count($parts) === 4) {
            array_pop($parts);
            $prefix = implode('.', $parts) . '.';
            $this->line("   - {$prefix} (prefix match for entire subnet)");
        }

        $this->newLine();
        $this->comment('Example SQL:');
        $this->line("INSERT INTO allowed_ip_ranges (clinic_location_id, ip_range, description, is_active, created_at, updated_at)");
        $this->line("VALUES (1, '{$serverIp}', 'Development Server', 1, NOW(), NOW());");

        return Command::SUCCESS;
    }
}
