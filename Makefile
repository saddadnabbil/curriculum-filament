fresh-seed:
	composer dump-autoload
	php artisan migrate:fresh --seed

route-clear:
	php artisan route:clear
	php artisan config:cache
	php artisan cache:clear
	php artisan config:clear
	php artisan route:cache

cache-clear:
    php artisan cache:clear
