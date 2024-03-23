# Executables (local)
DOCKER_COMP = APP_ENV=dev HTTP_PORT=8000 HTTPS_PORT=443 SERVER_NAME=http://localhost docker compose

# Docker containers
PHP_CONT = $(DOCKER_COMP) exec php

# Executables
PHP      = $(PHP_CONT) php
YARN      = $(PHP_CONT) yarn
COMPOSER = $(PHP_CONT) composer
SYMFONY  = $(PHP) bin/console
TEST  = $(PHP) bin/phpunit
TAIL = $(PHP_CONT) tail -f
PROJECT_NAME := $(shell git rev-parse --show-toplevel | xargs basename)

# Misc
.DEFAULT_GOAL = help
.PHONY        : help build up start down logs sh composer vendor sf cc

## —— 🎵 🐳 The Symfony Docker Makefile 🐳 🎵 ——————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'


## —— Docker 🐳 ————————————————————————————————————————————————————————————————
build:  ## Builds the Docker images
	@$(DOCKER_COMP)  build --pull --no-cache

build-dev:  ## Builds the Docker images
	@$(DOCKER_COMP) build --pull

up: ## Start the docker hub in detached mode (no logs)
	@$(DOCKER_COMP) up --detach --wait

start: build up ## Build and start the containers

dev: build-dev up ## Build and start the containers in dev mode

down: ## Stop the docker hub
	@$(DOCKER_COMP) down --remove-orphans

logs: ## Show live logs
	@$(DOCKER_COMP) logs --tail=0 --follow

sh: ## Connect to the PHP FPM container
	@$(PHP_CONT) sh

## —— Composer 🧙 ——————————————————————————————————————————————————————————————
composer: ## Run composer, pass the parameter "c=" to run a given command, example: make composer c='req symfony/orm-pack'
	@$(eval c ?=)
	@$(COMPOSER) $(c)

vendor: ## Install vendors according to the current composer.lock file
vendor: c=install --prefer-dist --no-dev --no-progress --no-scripts --no-interaction
vendor: composer

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
sf: ## List all Symfony commands or pass the parameter "c=" to run a given command, example: make sf c=about
	@$(eval c ?=)
	@$(SYMFONY) $(c)

cc: c=c:clear ## Clear the cache
cc: sf

test: ##  test f=tests/Command/CommandTest.php
	@$(eval f ?=)
	@$(TEST) $(f)

watch: ## Watch assets
	@$(YARN) watch

yp: ## Watch assets
	@$(YARN) encore production

