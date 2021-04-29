FROM php:8-apache

RUN apt-get update -qq \
    && apt-get install -qy --no-install-recommends \
    curl \
    libzip-dev \
    git

RUN docker-php-ext-install \
    mysqli \
    pdo_mysql \
    zip

# COPY ./voting.sql /var/lib/mysql
RUN chmod 777 /var/www/html -R
RUN a2enmod rewrite

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin && \
        echo "alias composer='composer'" >> /root/.bashrc && \
        composer