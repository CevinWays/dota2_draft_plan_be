up:
	docker compose up -d --build

down:
	docker compose down

restart:
	docker compose down && docker compose up -d --build

logs:
	docker compose logs -f

app-logs:
	docker compose logs -f app

db-logs:
	docker compose logs -f postgres

bash:
	docker compose exec app sh

composer-install:
	docker compose exec app composer install

init:
	docker compose exec app php artisan app:init

migrate:
	docker compose exec app php artisan migrate

fresh:
	docker compose exec app php artisan migrate:fresh --seed

seed:
	docker compose exec app php artisan db:seed

optimize:
	docker compose exec app php artisan optimize:clear

status:
	docker compose ps