FROM node:26-alpine AS assets

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
RUN npm run build


FROM php:8.3-apache

RUN apt-get update && apt-get install -y unzip git
RUN docker-php-ext-install pdo_mysql

# Límites de subida: por defecto PHP solo deja 2 MB por archivo y 8 MB por formulario
RUN printf "upload_max_filesize=5M\npost_max_size=30M\n" > /usr/local/etc/php/conf.d/uploads.ini

RUN a2enmod rewrite

RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .
COPY --from=assets /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader --no-interaction

# public/peticiones: carpeta donde Apache (www-data) guarda las fotos subidas
RUN mkdir -p public/peticiones && chown -R www-data:www-data storage bootstrap/cache public/peticiones

EXPOSE 80
