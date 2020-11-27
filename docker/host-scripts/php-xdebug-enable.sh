#!/usr/bin/env bash
# recover from backup xdebug config
docker-compose exec -T php mv /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini.bak /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
# force new config
docker-compose exec -T php kill -USR2 1