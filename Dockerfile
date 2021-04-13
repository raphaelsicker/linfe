FROM php:8.0.0-fpm-alpine3.12

ARG COMPOSER_AUTH
ENV COMPOSER_AUTH $COMPOSER_AUTH
ARG APP_STAGE
ENV APP_STAGE $APP_STAGE
ARG APP_ENV
ENV APP_ENV $APP_ENV

RUN apk --update add --no-cache \
    ${PHPIZE_DEPS} \
    oniguruma-dev \
    libpng \
    libpng-dev \
    libzip-dev \
    openssl-dev \
    nginx \
    supervisor \
    gd \
    nano \
    libxml2-dev \
    git \
    tzdata \
    curl \
    freetype \
    libjpeg-turbo \
    freetype-dev \
    && rm -rf /var/cache/apk/*

RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    gd \
    soap \
    xml \
    posix \
    tokenizer \
    ctype \
    pcntl \
    opcache

RUN pecl install -f apcu \
    && echo 'extension=apcu.so' > /usr/local/etc/php/conf.d/30_apcu.ini

RUN chmod -R 755 /usr/local/lib/php/extensions/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && chown -R www-data:www-data /var/lib/nginx \
    && mkdir -p /app \
    && chown -R www-data:www-data /app

WORKDIR /app

ENTRYPOINT ["sh", "-c"]

RUN pecl install timezonedb \
    docker-php-ext-enable timezonedb

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --version

RUN docker-php-ext-install zip xml posix ctype pcntl

COPY . /app

COPY docker/config/ /

COPY docker/scripts/ /

RUN if [ "$APP_STAGE" != "dev" ] ; then \
        composer install  --no-dev --no-interaction --optimize-autoloader ; \
    fi

RUN if [ "$APP_STAGE" == "dev" ] ; then \
        composer install; \
    fi

RUN if [ "$APP_STAGE" == "dev" ]; then \
    apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey=LINFE" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
fi

RUN addgroup -g 1000 -S www \
    && adduser -u 1000 -D -S -G www -h /app -g www www \
    && chown -R www:www /var/lib/nginx \
    && chown -R www:www /app \
    && chmod +x /docker-entrypoint.sh

ENTRYPOINT ["sh", "/docker-entrypoint.sh", "api"]
