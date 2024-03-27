install-n-start:
	make install
	make start
install:
	docker-compose up -d
	docker exec -it php-fpm-sr /bin/sh -c 'composer install'
	docker exec -it php-fpm-sr /bin/sh -c 'php bin/console doctrine:migrations:migrate'
	docker-compose stop
start:
	docker-compose up -d
	docker exec -it php-fpm-sr /bin/sh -c 'symfony server:start -d'
stop:
	docker-compose stop
