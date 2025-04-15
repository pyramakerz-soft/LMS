#!/bin/bash

echo "[EB] Fixing Laravel file permissions..."

cd /var/app/current

# Set correct ownership
sudo chown -R webapp:webapp .

# Set directory permissions
sudo find . -type d -exec chmod 755 {} \;

# Set file permissions
sudo find . -type f -exec chmod 644 {} \;

# Laravel storage and cache should be writable
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache

echo "[EB] Permissions fixed."
