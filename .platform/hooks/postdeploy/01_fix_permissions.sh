#!/bin/bash

echo "[POSTDEPLOY] Fixing Laravel permissions..."

cd /var/app/current || exit 1

# Set correct ownership for all files (important)
sudo chown -R webapp:webapp .

# Make sure directories are executable
find . -type d -exec chmod 755 {} \;

# Make sure files are readable
find . -type f -exec chmod 644 {} \;

# Laravel storage & cache must be writable
chmod -R 775 storage
chmod -R 775 bootstrap/cache

echo "[POSTDEPLOY] Permissions fixed."
