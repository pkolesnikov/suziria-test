#!/bin/bash

set -e

cd /var/www

echo "Installing dependencies..."
composer install --no-interaction

echo "Ready."
exec apache2-foreground