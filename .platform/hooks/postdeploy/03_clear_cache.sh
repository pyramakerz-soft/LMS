#!/bin/bash

echo "[POSTDEPLOY] Starting Laravel cache clear script..."

cd /var/www/html || {
  echo "[POSTDEPLOY] Failed to cd into /var/app/current"
  exit 1
}

# Log path
LOG_FILE="/tmp/eb-postdeploy-clear-cache.log"
touch "$LOG_FILE"

if [ ! -f artisan ]; then
  echo "[POSTDEPLOY] Artisan file not found!" | tee -a "$LOG_FILE"
  exit 1
fi

echo "[POSTDEPLOY] Running artisan commands..." | tee -a "$LOG_FILE"

php artisan config:clear      | tee -a "$LOG_FILE"
php artisan route:clear       | tee -a "$LOG_FILE"
php artisan view:clear        | tee -a "$LOG_FILE"
php artisan optimize          | tee -a "$LOG_FILE"

echo "[POSTDEPLOY] Laravel cache clear completed." | tee -a "$LOG_FILE"
