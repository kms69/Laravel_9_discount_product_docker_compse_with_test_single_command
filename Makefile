.PHONY: run
run:
	docker compose up --build
	docker exec -it theresa_app  bashe -c "php artisan migrate"

test: run
	docker exec -it theresa_app  bashe -c "php artisan db:seed --class=ProductTableSeeder ; ./vendor/bin/phpunit"
