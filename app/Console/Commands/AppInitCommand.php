<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class AppInitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init {--fresh : Drop all tables and re-run all migrations before seeding}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize application database (wait for DB, migrate, and seed)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🚀 Starting application initialization...');

        if (! $this->waitForDatabase()) {
            $this->error('❌ Database connection failed after multiple attempts.');
            return self::FAILURE;
        }

        $this->info('✅ Database connection established.');

        if ($this->option('fresh')) {
            $this->info('🧹 Running migrate:fresh --seed...');
            $this->call('migrate:fresh', [
                '--seed' => true,
                '--force' => true,
            ]);
        } else {
            $this->info('📦 Running migrate...');
            $this->call('migrate', [
                '--force' => true,
            ]);

            $this->info('🌱 Running db:seed...');
            $this->call('db:seed', [
                '--force' => true,
            ]);
        }

        $this->info('🎉 Application initialization completed successfully.');

        return self::SUCCESS;
    }

    /**
     * Wait until the database is reachable.
     */
    protected function waitForDatabase(int $maxAttempts = 15, int $sleepSeconds = 2): bool
    {
        $this->info('⏳ Waiting for database connection...');

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            try {
                DB::connection()->getPdo();

                $this->line("✔ DB ready on attempt {$attempt}/{$maxAttempts}");
                return true;
            } catch (Throwable $e) {
                $this->warn("Attempt {$attempt}/{$maxAttempts}: DB not ready yet...");

                if ($attempt < $maxAttempts) {
                    sleep($sleepSeconds);
                }
            }
        }

        return false;
    }
}