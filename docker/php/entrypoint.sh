#!/usr/bin/env bash
set -e

if [ $# -eq 0 ]; then
	sed -ie "s/`id -u www-data`:`id -g www-data`/`stat -c %u /srv`:`stat -c %g /srv`/g" /etc/passwd
	php-fpm
else
    exec "$@"
fi

