#!/bin/bash

echo "[POSTDEPLOY] Ensuring .env is available..."

# Create .env from .env.prod inside /var/app/current
if [ ! -f /var/app/current/.env ]; then
    echo "[POSTDEPLOY] Copying .env.prod to .env in current directory..."
    cp /var/app/current/.env.prod /var/app/current/.env
else
    echo "[POSTDEPLOY] .env already exists."
fi

echo "[POSTDEPLOY] Running Laravel tasks..."

cd /var/app/current

# Permissions just in case
chmod -R 775 storage bootstrap/cache

php artisan config:clear
php artisan migrate --force
php artisan db:seed --force
php artisan optimize

echo "[POSTDEPLOY] Done."
