<?php

namespace App\Console\Commands;

use App\Services\HeroSyncService;
use Illuminate\Console\Command;

class SyncHeroesCommand extends Command
{
    protected $signature = 'app:sync-heroes';
    protected $description = 'Sync heroes from OpenDota API to the local database';

    public function handle(HeroSyncService $service)
    {
        $this->info('Starting Hero Sync from OpenDota...');
        
        $result = $service->syncHeroes();

        if ($result['success']) {
            $this->info('Successfully synchronized ' . $result['count'] . ' heroes.');
            return Command::SUCCESS;
        }

        $this->error('Failed to synchronize heroes: ' . $result['error']);
        return Command::FAILURE;
    }
}
