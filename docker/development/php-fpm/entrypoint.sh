#!/bin/sh
set -e

# Check if $UID and $GID are set, else fallback to default (1000:1000)
USER_ID=${UID:-1000}
GROUP_ID=${GID:-1000}

# Fix file ownership and permissions using the passed UID and GID
echo "Fixing file permissions with UID=${USER_ID} and GID=${GROUP_ID}..."
chown -R ${USER_ID}:${GROUP_ID} /var/www || echo "Some files could not be changed"

# Clear configurations to avoid caching issues in development
echo "Clearing configurations..."

# Set PGPASSWORD environment variable for authentication
export PGPASSWORD=${DB_PASSWORD}

# Check if the PostgreSQL database exists, and create it if not
echo "Checking if database exists..."
psql -h postgres -U ${DB_USERNAME} -d postgres -c "SELECT 1 FROM pg_database WHERE datname='${DB_DATABASE}'" | grep -q 1 || \
psql -h postgres -U ${DB_USERNAME} -d postgres -c "CREATE DATABASE ${DB_DATABASE};"

# Run Laravel migrations (only in development)
php artisan migrate:fresh --seed


php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run the default command (e.g., php-fpm or bash)
exec "$@"
