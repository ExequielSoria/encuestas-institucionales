FROM php:7.4-apache

#Librerias necesarias para composer
RUN apt-get update && apt-get install -y curl unzip
# Descargo e instalo Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#Librerias necesarias para cosas de base de datos
RUN apt-get update && apt-get install --yes --no-install-recommends \
    zlib1g-dev \
    libzip-dev \
    unzip \    
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libssl-dev \
    && docker-php-ext-install zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql

WORKDIR /var/www/html/

COPY . /var/www/html/

COPY .env /var/www/html/
    
LABEL description="PHP + GD + Apache + PDO"