#!/bin/sh
/var/www/optibet_test

composer install;
php bin/console doctrine:database:drop --force;
php bin/console doctrine:database:create;
php bin/console doctrine:schema:update --force;
php bin/console doctrine:fixtures:load --no-interaction;