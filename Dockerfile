# Stage 1: Builder
FROM php:8.3-fpm as builder

WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip bcmath

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application files and install dependencies
COPY . .
RUN composer install --no-dev --optimize-autoloader

# Build frontend assets
RUN npm install
RUN npm run build

# Stage 2: Final Production Image
FROM php:8.3-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y nginx

# Copy application code from builder stage
COPY --from=builder /app .

# Copy Nginx configuration
COPY docker/nginx.conf /etc/nginx/sites-enabled/default

# Copy start script
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Set permissions for Laravel
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

EXPOSE 80

CMD ["/usr/local/bin/start.sh"]