.PHONY: help build start stop restart logs ps

help:
	@echo "Commands:"
	@echo "  make build         			- Build containers"
	@echo "  make start         			- Start containers"
	@echo "  make setup         			- Setup containers"
	@echo "  make stop          			- Stop containers"
	@echo "  make restart       			- Restart containers"
	@echo "  make logs          			- Show logs"
	@echo "  make symfony-cache-clear  		- Clear symfony cache"
	@echo "  make ps              			- Show status containers"
	@echo "  make test              		- Execute application tests"
	@echo "  make app-bash      			- Bash into app container"
	@echo "  make docker-ease      			- Ease docker"
	@echo "  make docker-prune      		- Prune docker"
	
app-bash:
	docker compose exec php /bin/bash -c "cd /var/www/html && exec /bin/bash"

build:
	docker compose build

docker-ease:
	docker system prune --volumes --filter="label!=com.docker.compose.project" --force

docker-prune:
	docker system prune --force
	docker image prune --all --force

logs:
	docker compose logs -f

start:
	docker compose up -d

stop:
	docker compose down

setup:
	docker compose exec php composer clearcache
	docker compose exec php composer install --no-scripts
	docker compose exec php /bin/bash -c "cd /var/www/html && php bin/console doctrine:migrations:migrate --no-interaction -q"
	docker compose exec php /bin/bash -c "cd /var/www/html && php bin/console doctrine:schema:validate"

symfony-cache-clear:
	docker compose exec php /bin/bash -c "cd /var/www/html && php -d memory_limit=1G bin/console cache:clear"

test:
	docker compose exec php /bin/bash -c "cd /var/www/html && php -d memory_limit=1G vendor/bin/phpunit"

ps:
	docker compose ps

restart: stop start

.DEFAULT_GOAL := help
