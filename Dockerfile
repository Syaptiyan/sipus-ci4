FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libzip-dev zip unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY . /var/www/html/

WORKDIR /var/www/html/public

# Create writable directories and set permissions
RUN mkdir -p ../writable/cache ../writable/logs ../writable/session ../writable/uploads \
    && chmod -R 777 ../writable

EXPOSE 80
CMD ["php", "-S", "0.0.0.0:80"]
