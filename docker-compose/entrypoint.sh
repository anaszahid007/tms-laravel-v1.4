#!/bin/sh

set -e

# Wait for database
echo "Waiting for database..."
while ! nc -z db 5432; do
  sleep 1
done
echo "Database is ready!"

# Wait for redis
echo "Waiting for redis..."
while ! nc -z redis 6379; do
  sleep 1
done
echo "Redis is ready!"

# Generate key if not set
if [ -z "$APP_KEY" ]; then
    echo "Generating app key..."
    php artisan key:generate --force
fi

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Cache config, routes, views for speed
echo "Optimizing..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# If arguments are passed (e.g. queue:work), run them
if [ $# -gt 0 ]; then
    exec "$@"
else
    echo "Starting Laravel server..."
    exec php artisan serve --host=0.0.0.0 --port=8000
fi
