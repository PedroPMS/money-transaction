#Dockerfile vars
alpver=3.12
kctlver=1.18.0

#vars
IMAGENAME=my_kubectl
REPO=my.registry
IMAGEFULLNAME=${REPO}/${IMAGENAME}:${KUBECTL_VERSION}

.PHONY: help build push all

help:
	    @echo "Makefile arguments:"
	    @echo ""
	    @echo "build - Build Enviroment"

.DEFAULT_GOAL := all

build:
	    @docker-compose up -d --build
	    @docker exec -it money-app php artisan key:generate
up:
	    @docker-compose up -d
down:
	    @docker-compose down
test:
	    @$(eval testsuite ?= 'all')
	    @$(eval filter ?= '.')
	    @docker exec -it money-app vendor/bin/phpunit --filter=$(filter) --stop-on-failure
migrate:
	    @docker exec -it money-app php artisan migrate --database=testing --seed
	    @docker exec -it money-app php artisan migrate --seed

push:
	    @docker push ${IMAGEFULLNAME}

docs:
	    @docker exec -it money-app php artisan scribe:generate

lint:
		@docker exec -it money-app vendor/bin/pint

all: build push
