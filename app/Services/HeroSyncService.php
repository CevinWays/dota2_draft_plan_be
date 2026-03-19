<?php

namespace App\Services;

use App\Models\Hero;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HeroSyncService
{
    private const OPENDOTA_HEROES_URL = 'https://api.opendota.com/api/heroes';

    public function syncHeroes(): array
    {
        try {
            $response = Http::get(self::OPENDOTA_HEROES_URL);

            if ($response->successful()) {
                $heroes = $response->json();
                $syncedCount = 0;

                foreach ($heroes as $heroData) {
                    Hero::updateOrCreate(
                        ['opendota_hero_id' => $heroData['id']],
                        [
                            'name' => $heroData['name'],
                            'localized_name' => $heroData['localized_name'],
                            'primary_attr' => $heroData['primary_attr'],
                            'attack_type' => $heroData['attack_type'],
                            'roles' => $heroData['roles'] ?? null,
                            // You might fetch images from another OpenDota endpoint or CDN
                            // if needed later.
                        ]
                    );
                    $syncedCount++;
                }
                
                return ['success' => true, 'count' => $syncedCount];
            }

            Log::error('OpenDota API returned an error', ['status' => $response->status()]);
            return ['success' => false, 'error' => 'API returned status ' . $response->status()];
        } catch (\Exception $e) {
            Log::error('Exception while syncing heroes', ['message' => $e->getMessage()]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
