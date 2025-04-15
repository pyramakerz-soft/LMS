#!/bin/bash

echo "[POSTDEPLOY] Fixing Laravel permissions..."

# Make sure Laravel's public directory and storage paths are readable/executable
chmod -R 755 /var/app/current/public
chmod -R 775 /var/app/current/storage
chmod -R 775 /var/app/current/bootstrap/cache

echo "[POSTDEPLOY] Permissions fixed"
