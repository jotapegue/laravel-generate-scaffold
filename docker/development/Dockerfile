FROM php:8.2-apache as DEV

ARG uid

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    zlib1g-dev \
    libmcrypt-dev \
    libpng-dev \
    libzip-dev \
    libsodium-dev &&\
    docker-php-ext-install mbstring xml exif pcntl bcmath gd zip sodium intl && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

COPY --from=composer /usr/bin/composer /usr/local/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/developer developer

RUN mkdir -p /home/developer/.composer && \
    chown -R developer:developer /home/developer

ENV PATH="$PATH:~/.composer/vendor/bin"

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

USER developer