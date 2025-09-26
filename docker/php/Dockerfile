FROM php:8.4-fpm

WORKDIR /var/www/html

RUN groupadd -g 1000 developer && useradd -u 1000 -ms /bin/bash -g developer developer

RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache /var/www/.composer \
    && chown -R developer:developer /var/www/html /var/www/.composer

RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    nodejs && \
    docker-php-ext-install pdo_mysql exif pcntl zip && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

USER developer

EXPOSE 9000

CMD ["php-fpm"]
