FROM php:8.1-fpm

ARG user

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && apt-get install -y \
    libpq-dev \
    curl \
    git \
    zip \
    unzip

RUN docker-php-ext-install pdo_pgsql \
    && pecl install mongodb \
    && docker-php-ext-enable pdo_pgsql \
    && docker-php-ext-enable mongodb


RUN useradd -G www-data,root -d /home/$user $user
COPY ./.docker/app-start /usr/local/bin/app-start
RUN chmod +x /usr/local/bin/app-start;

RUN mkdir -p /home/$user/.composer \
    && chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

USER $user

CMD app-start
