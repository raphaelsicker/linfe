FROM php:fpm

# Instalação do Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

#apt
RUN apt update
RUN apt install zip unzip

# Extensões do docker
RUN docker-php-ext-install pdo pdo_mysql
RUN pecl install xdebug && docker-php-ext-enable xdebug

WORKDIR /app
