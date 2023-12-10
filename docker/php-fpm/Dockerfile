вFROM php:8.2-fpm-alpine

RUN apk update && apk upgrade && apk add git && \
    apk add --no-cache icu-dev postgresql-dev libzip-dev g++ make && \
    docker-php-ext-configure intl && \
    docker-php-ext-install pdo_pgsql pgsql zip intl && \
    rm -rf /var/cache/apk/* && rm -rf /tmp/*

RUN apk add --update linux-headers

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN apk add --no-cache bash && \
    curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash && \
    apk add symfony-cli

RUN git config --global user.name "k.petrushina" && \
    git config --global user.email k.petrushina@etpgpb.ru


WORKDIR /app
