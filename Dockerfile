# =====================================================
# TailorOnDesk — Dockerfile (Code Baked In)
# No bind mounts = fast on Windows Docker
# =====================================================
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    postgresql-client \
    nodejs \
    npm \
    zip \
    unzip \
    netcat-openbsd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd opcache

# Install phpredis extension (required for REDIS_CLIENT=phpredis)
RUN pecl install redis && docker-php-ext-enable redis

# Copy OPcache configuration
COPY docker-compose/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# ── Step 1: Copy composer files first (layer caching) ──
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-dev --optimize-autoloader --no-scripts

# ── Step 2: Copy package.json for npm (layer caching) ──
COPY package.json package-lock.json ./
RUN npm ci --prefer-offline

# ── Step 3: Copy the rest of the application source ──
COPY . .

# ── Step 4: Build frontend assets ──
RUN npm run build

# ── Step 5: Run post-install composer scripts ──
RUN composer run-script post-autoload-dump || true

# Set proper permissions
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Copy entrypoint
COPY docker-compose/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

USER www-data

ENTRYPOINT ["entrypoint.sh"]
