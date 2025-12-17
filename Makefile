init: down build up migrate

test:
	@docker compose run --rm app-php-cli composer test

build:
	docker compose build --pull

up:
	docker compose up -d

down:
	docker compose down --remove-orphans

app:
	@docker compose run --rm app-php-cli composer app

lint:
	docker compose run --rm app-php-cli composer php-cs-fixer fix -- --dry-run --diff

cs-fix:
	docker compose run --rm app-php-cli composer php-cs-fixer fix

migrate:
	cat ./database/scheme.sql | docker compose exec -T db psql -U demo

.PHONY: test build up down app init migrate cs-fix lint
