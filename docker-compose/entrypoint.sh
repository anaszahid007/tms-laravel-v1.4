#!/bin/sh

# Exit on error
set -e

# Wait for database to be ready
echo "Waiting for database..."
while ! nc -z db 5432; do
  sleep 1
done
echo "Database is ready!"

# Wait for redis to be ready
echo "Waiting for redis..."
while ! nc -z redis 6379; do
  sleep 1
done
echo "Redis is ready!"

# Install composer dependencies if not already installed
if [ ! -d "vendor" ]; then
    echo "Installing composer dependencies..."
    composer install --no-interaction --optimize-autoloader
fi

# Generate key if not already generated
if [ -z "$APP_KEY" ]; then
    echo "Generating app key..."
    php artisan key:generate
fi

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# If arguments are passed, execute them, otherwise start Laravel server
if [ $# -gt 0 ]; then
    echo "Executing command: $@"
    exec "$@"
else
    echo "Starting Laravel Development Server..."
    exec php artisan serve --host=0.0.0.0 --port=8000
fi
