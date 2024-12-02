FROM php:8.0.2-cli-alpine

WORKDIR /app

RUN apk add --no-cache \
        bash \
        file \
        gettext \
        make \
        git \
        vim \
        zip \
        shadow \
        tzdata

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions zip xdebug \
    && rm -rf /tmp/* /var/tmp/*

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl --output composer-setup.php https://getcomposer.org/installer \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

ENV XDEBUG_CONFIG='client_host=host.docker.internal client_port=9003 start_with_request=yes idekey=PHPSTORM'
ENV XDEBUG_MODE=debug
ENV PHP_IDE_CONFIG='serverName=fakturownia'
