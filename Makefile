.DEFAULT_GOAL := help

#
# Project related
#

docker-project-setup-users:    ## Project: setup users
	docker-compose exec php ./yii user/user-password admin admin
	docker-compose exec php ./yii user/user-password user1 user1
	docker-compose exec php ./yii user/user-password user2 user2
	docker-compose exec php ./yii user/user-password user3 user3
	docker-compose exec php ./yii user/user-password user4 user4
	docker-compose exec php ./yii user/user-password user5 user5
	docker-compose exec php ./yii user/user-password user6 user6
	docker-compose exec php ./yii user/user-password user7 user7
	docker-compose exec php ./yii user/user-password user8 user8
	docker-compose exec php ./yii user/user-password user9 user9

#
# General stuff
#

docker-init-project:     ## For docker: init project after cloning
	make docker-composer-install
	make docker-yii-init
	make docker-migrate
	sudo chgrp 33 backend/views
	sudo chgrp 33 backend/controllers
	sudo chgrp 33 common/models

docker-composer-install: ## For docker: install dependencies
	docker-compose exec -T php composer i --prefer-dist

docker-migrate: ## For docker: migrate up
	docker-compose exec -T php ./yii migrate

docker-yii-init: ## For docker: install dependencies
	docker-compose exec -T php ./init --overwrite=y

docker-reset-db:         ## For docker: resets local database to the dumps, sets up tests database, runs migrations. Read the docs in 4develop/install_by_docker.md
	docker-compose down
	@echo "Cleaning databases..."
	sudo rm -rf docker/local-data/mysql-data/db/*
	docker-compose up -d
	@echo "Waiting database dumps to fill from docker/etc/mysql-init..."
	docker-compose exec -T db mysqladmin ping -h 127.0.0.1 -u root --password=root --wait=600 && docker-compose exec php ./yii migrate --interactive=0
	make docker-prepare-tests
	docker-compose up

docker-prepare-tests:    ## For docker: resets tests database and prepares tests
	@echo "Importing dump for tests..."
	echo "DROP DATABASE IF EXISTS yii2advanced_test; CREATE DATABASE yii2advanced_test;" | docker-compose exec -T db mysql -uroot -proot
	# docker-compose exec -T php zcat 4develop/sql_dump.zip | docker-compose exec -T db mysql -uroot -proot yii2advanced_test
	./docker/host-scripts/php-xdebug-disable.sh
	docker-compose exec -T php ./yii_test migrate --interactive=0
	docker-compose exec -T php vendor/bin/codecept build

docker-prepare-xdebug:   ## For docker: prepares xdebug, adds host.docker.internal to php container /etc/hosts
	docker-compose exec -T php ./docker/scripts/add-host.docker.internal-to-hosts.sh

docker-enable-xdebug:    ## For docker: enables xdebug in php
	make docker-prepare-xdebug
	./docker/host-scripts/php-xdebug-enable.sh

docker-disable-xdebug:   ## For docker: disables xdebug in php
	./docker/host-scripts/php-xdebug-disable.sh

# XXX docker-regen:           ## For docker: run regen
#	./docker/host-scripts/php-xdebug-disable.sh; time docker-compose exec --user $(id -u) -T php bash regen4unixAndMacOS.bat && ./fix-docker-permissions.sh && docker-compose restart

# XXX docker-update-dev-dump: ## For docker: dump current dev dump into 4develop/sql_dump.zip
#	docker-compose exec -T db mysqldump --opt -uroot -proot yii2advanced_test | gzip > 4develop/sql_dump.zip

help:                    ## Help
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'