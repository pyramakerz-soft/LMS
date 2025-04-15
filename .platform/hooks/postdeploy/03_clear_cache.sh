#!/bin/bash

echo "[POSTDEPLOY] Clearing Laravel cache..."

cd /var/app/current || exit 1

if [ -f artisan ]; then
  php artisan config:clear
  php artisan route:clear
  php artisan view:clear
  php artisan optimize
else
  echo "[POSTDEPLOY] Artisan not found — skipping."
fi
