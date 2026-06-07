#!/bin/bash
# Exit immediately if a command exits with a non-zero status
set -e

# Detect if the container is booting the Web Service or a CLI/Worker command
# Web service runs "frankenphp run ..." or defaults to empty (which executes frankenphp)
if [ "$1" = "frankenphp" ] || [ -z "$1" ]; then
    echo "⚡ Web Container booting. Preparing Laravel for production..."

    # Ensure storage directories are writable
    chmod -R 775 storage bootstrap/cache

    # Cache config, routes, and views for high performance in production
    echo "📌 Caching application bootstrap configurations..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

    # Run migrations
    echo "🚀 Running database migrations..."
    php artisan migrate --force

    # Run idempotent production seeder
    echo "🌱 Seeding default plans, settings, and templates..."
    php artisan db:seed --class=ProductionSeeder --force
fi

# Execute the main container command (passed via Docker CLI / CMD)
if [ $# -gt 0 ]; then
    echo "👉 Executing command: $@"
    exec "$@"
else
    echo "🔥 Starting FrankenPHP Server..."
    exec frankenphp run --config /etc/caddy/Caddyfile
fi
