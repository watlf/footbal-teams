DOCKER := $(shell which docker)
DOCKER_COMPOSE := $(shell which docker-compose)

container-down:
	$(DOCKER) stop $$(docker ps -a -q)
	$(DOCKER) rm $$(docker ps -a -q)

container-build:
	$(DOCKER_COMPOSE) build --no-cache
	$(DOCKER_COMPOSE) up -d
	$(DOCKER) exec -it footbal_teams_php bash -c "composer install"
	$(DOCKER) exec -it footbal_teams_php bash -c "php bin/console --no-interaction doctrine:migrations:migrate"
	$(DOCKER) exec -it footbal_teams_php bash -c "php bin/console --no-interaction doctrine:fixtures:load"

test:
	$(DOCKER) exec -it footbal_teams_php bash -c "vendor/bin/phpunit"
