# /usr/bin/make


start:
	cp .env.example .env
	docker-compose up --build --force-recreate -d
	docker exec -t ariana-co-php bash -c "composer install; php artisan key:generate; php artisan migrate --seed; php artisan storage:link"
