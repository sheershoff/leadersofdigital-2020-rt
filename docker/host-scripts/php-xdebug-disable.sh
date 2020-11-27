#!/usr/bin/env bash
# backup xdebug config
docker-compose exec -T php mv /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini.bak
# force new config
docker-compose exec -T php kill -USR2 1