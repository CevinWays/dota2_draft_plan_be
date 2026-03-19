# Folder Architecture

## Backend Project Structure

```text
dota2-draft-planner-api/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       └── SyncHeroesCommand.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── Auth/
│   │   │   │   │   └── AuthController.php
│   │   │   │   ├── HeroController.php
│   │   │   │   ├── DraftPlanController.php
│   │   │   │   ├── DraftPlanBanController.php
│   │   │   │   ├── DraftPlanPreferredPickController.php
│   │   │   │   ├── DraftPlanEnemyThreatController.php
│   │   │   │   └── DraftPlanItemTimingController.php
│   │   ├── Requests/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginRequest.php
│   │   │   │   └── RegisterRequest.php
│   │   │   ├── DraftPlan/
│   │   │   │   ├── StoreDraftPlanRequest.php
│   │   │   │   └── UpdateDraftPlanRequest.php
│   │   │   ├── DraftPlanBan/
│   │   │   │   ├── StoreDraftPlanBanRequest.php
│   │   │   │   └── UpdateDraftPlanBanRequest.php
│   │   │   ├── DraftPlanPreferredPick/
│   │   │   │   ├── StoreDraftPlanPreferredPickRequest.php
│   │   │   │   └── UpdateDraftPlanPreferredPickRequest.php
│   │   │   ├── DraftPlanEnemyThreat/
│   │   │   │   ├── StoreDraftPlanEnemyThreatRequest.php
│   │   │   │   └── UpdateDraftPlanEnemyThreatRequest.php
│   │   │   └── DraftPlanItemTiming/
│   │   │       ├── StoreDraftPlanItemTimingRequest.php
│   │   │       └── UpdateDraftPlanItemTimingRequest.php
│   │   ├── Resources/ (Implicitly needed for API resources)
│   ├── Models/
│   │   ├── User.php
│   │   ├── Hero.php
│   │   ├── DraftPlan.php
│   │   ├── DraftPlanBan.php
│   │   ├── DraftPlanPreferredPick.php
│   │   ├── DraftPlanEnemyThreat.php
│   │   └── DraftPlanItemTiming.php
│   └── Services/
│       └── HeroSyncService.php
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php
│       └── HeroSeeder.php
├── routes/
│   └── api.php
├── docker/
│   ├── php/
│   │   └── Dockerfile
│   └── nginx/
├── docker-compose.yml
└── README.md
```

## Key Principles

- **Domain Separation:** Controllers are split by domain/feature for better maintainability.
- **Clean Validation:** Using `FormRequest` classes to keep controller logic focused and validation code clean.
- **Service Layer:** `HeroSyncService` handles integration with external APIs (OpenDota).
- **Automation:** Artisan commands (`SyncHeroesCommand`) allow for scheduled or manual hero data synchronization.
