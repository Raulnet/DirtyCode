DOCKER_COMPOSE  = docker-compose

EXEC_PHP        = $(DOCKER_COMPOSE) exec php entrypoint
EXEC_JS         = $(DOCKER_COMPOSE) exec node entrypoint

SYMFONY         = $(EXEC_PHP) bin/console
VENDOR_BIN      = $(EXEC_PHP) vendor/bin
COMPOSER        = $(EXEC_PHP) composer
YARN            = $(EXEC_JS) yarn

.DEFAULT_GOAL := help
help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.PHONY: help

###-------------------------#
###      Project            #
###-------------------------#
build:
	@$(DOCKER_COMPOSE) pull --parallel --quiet --ignore-pull-failures 2> /dev/null
	$(DOCKER_COMPOSE) build --pull

kill:
	$(DOCKER_COMPOSE) kill
	$(DOCKER_COMPOSE) down --volumes --remove-orphans

install: build start vendor assets db ## Install and start the project

reset: clean kill install ## Stop and start a fresh install of the project

start: ## Start the project
	$(DOCKER_COMPOSE) up -d --remove-orphans --no-recreate
	@echo "Dirtycode should be started and running on http://dirtycode.wip/"

stop: ## Stop the project
	$(DOCKER_COMPOSE) stop

no-docker:
	$(eval DOCKER_COMPOSE := \#)
	$(eval EXEC_PHP := )
	$(eval EXEC_JS := )

composer.lock: composer.json # rules based on files
	$(COMPOSER) update --lock --no-scripts --no-interaction

vendor: composer.lock
	$(COMPOSER) install

.PHONY: build kill install reset start stop clean no-docker vendor

###-------------------------#
###      Tools              #
###-------------------------#
bash-php: ## go to docker app bash
	$(EXEC_PHP) bash

clear: ## Remove all the cache, the logs and the built assets
	$(EXEC_PHP) rm -rf var/cache/*
	$(EXEC_PHP) rm -rf var/log/*
	@if [ -f .php_cs.cache ]; \
	then\
		$(EXEC) rm .php_cs.cache ; \
	fi

clean: clear ## clean and remove vendor and node_modules
	$(EXEC_PHP) rm -rf public/build
	$(EXEC_PHP) rm -rf public/bundles
	$(EXEC_PHP) rm -rf vendor
	$(EXEC_JS) rm -rf node_modules

.PHONY: clean clear bash

###-------------------------#
###      Databases          #
###-------------------------#

db: vendor db-create db-migrate fixtures ## Build DBdatabase and load fixtures

db-reset: vendor db-drop db ## Reset the database and load fixtures

db-drop:
	$(EXEC_PHP) rm -rf var/data.db

db-create:
	$(SYMFONY) doctrine:database:create

db-diff: vendor  ## Generate a new doctrine migration
	$(SYMFONY) doctrine:migrations:diff --formatted

db-migrate: vendor  ## Migrate a new doctrine migration
	$(SYMFONY) doctrine:migrations:migrate --no-interaction

db-validate-schema: vendor ## Validate the doctrine ORM mapping
	$(SYMFONY) doctrine:schema:validate

fixtures:
	$(SYMFONY) doctrine:fixtures:load --no-interaction

.PHONY: db-reset db-drop db-create migration fixtures

###-------------------------#
###      Node               #
###-------------------------#

assets: node_modules  ## Run Webpack Encore to compile assets
	$(YARN) run dev

watch: node_modules ## Run Webpack Encore in watch mode
	$(YARN) run watch

node_modules:
	$(YARN) install
	@touch -c node_modules

yarn.lock: package.json
	$(YARN) upgrade

.PHONY: assets watch

###-------------------------#
###          QA             #
###-------------------------#
qa: clear cs lt ly tu ## launch analys php-cs-fixer && phpunit

tu: ## launch phpunit
	$(VENDOR_BIN)/simple-phpunit

cs: ## analys php-cs-fixer (http://cs.sensiolabs.org)
	$(VENDOR_BIN)/php-cs-fixer fix --diff --dry-run --no-interaction -v

csfix: ## fix php-cs-fixer (http://cs.sensiolabs.org)
	$(VENDOR_BIN)/php-cs-fixer fix --diff --no-interaction -v

lt: ## launch lint twig
	$(SYMFONY) lint:twig ./src/Custom/
	$(SYMFONY) lint:twig ./templates/

ly: ## launch lint Yaml
	$(SYMFONY) lint:yaml ./src/Custom/
	$(SYMFONY) lint:yaml ./translations/
	$(SYMFONY) lint:yaml ./config/ --parse-tags

.PHONY: qa tu cs csfix lt ly
