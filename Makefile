.PHONY: bddReset
bddReset:
	docker exec -it 4iw2-tp-symfony-php-1 php bin/console doctrine:database:drop --force --if-exists
	docker exec -it 4iw2-tp-symfony-php-1 php bin/console doctrine:database:create
	docker exec -it 4iw2-tp-symfony-php-1 php bin/console doctrine:migrations:migrate --no-interaction
	docker exec -it 4iw2-tp-symfony-php-1 php bin/console doctrine:fixtures:load --no-interaction
