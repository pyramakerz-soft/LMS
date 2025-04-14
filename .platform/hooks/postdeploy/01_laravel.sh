#!/bin/bash
# Ensure this script is executable: chmod +x

echo "Running Laravel post-deploy tasks..."

cd /var/app/current

# Ensure proper permissions if needed
chmod -R 775 storage bootstrap/cache

# Run Laravel tasks
php artisan migrate --force
php artisan db:seed --force
php artisan optimize

echo "Laravel post-deploy tasks completed."
