FROM php:8.2-cli

# Installer les dépendances système et extensions PHP
RUN apt-get update && apt-get install -y \
    git curl libpq-dev libzip-dev zip unzip nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

RUN php artisan config:clear

EXPOSE 10000

CMD php artisan migrate --force && php artisan serve --host 0.0.0.0 --port 10000