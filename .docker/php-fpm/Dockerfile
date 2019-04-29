FROM php:7.3.4-fpm-alpine3.9

LABEL maintainer="kyronbao@gmail.com"

# alpinelinux repositories use china mirrors, if need, replace it
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories

RUN apk --no-cache --update \
    add curl \
    vim \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    openssl-dev \
    libmcrypt-dev \
    libzip-dev \
    && docker-php-ext-install \
    # Install the PHP pdo_mysql extension
    pdo_mysql \
    # Install the PHP ZipArchive:
    zip \
    # Install the PHP gd library
    && docker-php-ext-configure gd \
    --with-jpeg-dir=/usr/lib \
    --with-freetype-dir=/usr/include/freetype2 && \
    docker-php-ext-install gd \
    &&  rm -rf /var/cache/apk/* /tmp/* /var/tmp/*

# composer repositories use china mirrors, if need, replace it
RUN wget https://dl.laravel-china.org/composer.phar -O /usr/local/bin/composer \
    && chmod a+x /usr/local/bin/composer \
    && composer config -g repo.packagist composer https://packagist.laravel-china.org

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000