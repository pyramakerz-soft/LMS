#!/bin/bash

echo "[POSTDEPLOY] Ensuring .env is available..."

cd /var/app/current

# Copy .env.prod to .env if it doesn't exist
if [ ! -f .env ]; then
    echo "[POSTDEPLOY] Copying .env.prod to .env..."
    cp .env.prod .env
else
    echo "[POSTDEPLOY] .env already exists."
fi
# Set correct ownership
sudo chown -R webapp:webapp storage bootstrap/cache

# Ensure log file and required directories exist
mkdir -p storage/logs
touch storage/logs/laravel.log

# Fix permissions for Laravel
chmod -R 777 storage
chmod -R 775 storage bootstrap/cache
chmod 777 /var/app/current/storage/logs/laravel.log
sudo yum install npm -y
npm install
npm run build
# Generate APP_KEY only if not already set
if grep -q "APP_KEY=" .env && grep -q "^APP_KEY=$" .env; then
    echo "[POSTDEPLOY] Generating new APP_KEY..."
    php artisan key:generate --force
else
    echo "[POSTDEPLOY] APP_KEY already exists, skipping key:generate."
fi


# Run Laravel optimization commands
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize

# Run migrations and seed database
php artisan migrate --force
php artisan db:seed --force

echo "[POSTDEPLOY] Deployment tasks completed."
