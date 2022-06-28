FROM php:7.4-fpm

ARG user

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && apt-get install -y \
    libpq-dev

RUN docker-php-ext-install pdo_pgsql \
    && docker-php-ext-enable pdo_pgsql


RUN useradd -G www-data,root -d /home/$user $user

RUN mkdir -p /home/$user/.composer \
    && chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

USER $user
