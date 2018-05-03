# Do `sh laravel.sh up`   to start app
# Do `sh laravel.sh down` to stop  app

if [ $1 = "up" ]; then
	composer install
	docker-compose up -d
	php artisan serve &
	php artisan up
	echo sleeping for 10s
	sleep 10s
	php artisan migrate
	php artisan migrate:status
	xdg-open "http://127.0.0.1:8000/"
	xdg-open "http://127.0.0.1:5050/"
elif [ $1 = "down" ]; then
	docker-compose down
	# kill $(ps aux | grep artisan | awk '{print $2}')
	kill $(lsof -t -i:8000)
fi
