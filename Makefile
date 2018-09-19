DOCKER := $(shell which docker)
DOCKER_COMPOSE := $(shell which docker-compose)

docker-down:
	$(DOCKER) stop $$(docker ps -a -q)
	$(DOCKER) rm $$(docker ps -a -q)

docker-build:
	$(DOCKER_COMPOSE) build --no-cache
	$(DOCKER_COMPOSE) up -d
	$(DOCKER) exec -it footbal_teams_php bash -c "composer install"
	$(DOCKER) exec -it footbal_teams_php bash -c "php bin/console make:migration"
