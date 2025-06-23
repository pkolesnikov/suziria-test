#!/bin/bash

set -e

cd /var/www

echo "Installing dependencies..."
composer install --no-interaction

echo "Running DB migrations and seed..."
php /var/www/src/setup.php

echo "Ready."
exec apache2-foreground