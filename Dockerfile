FROM php:8.2-cli

# System dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip \
    && pecl install redis \
    && docker-php-ext-enable redis

# Workdir
WORKDIR /app

# Copy files
COPY . /app

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer dump-autoload

# Start bot
CMD ["php", "index.php"]
