#!/bin/bash

set -e

cd /var/www

echo "Installing dependencies..."
composer install --no-interaction

echo "Running setup script..."
php /var/www/src/setup.php

echo "Ready."
exec apache2-foreground