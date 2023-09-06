FROM alpine:3.18.3

RUN apk add --no-cache zip unzip curl supervisor
RUN apk add bash
RUN sed -i 's/bin\/ash/bin\/bash/g' /etc/passwd

RUN apk update && apk --no-cache add \
    php82 \
    php82-fpm \
    php82-pdo \
    php82-pdo_mysql \
    php82-mbstring \
    php82-openssl \
    php82-session

RUN   apk --no-cache add \
      php82-json \
      php82-dom \
      php82-curl

RUN   apk --no-cache add \
      php82-tokenizer

RUN     apk --no-cache add \
        php82-phar \
        php82-fileinfo \
        php82-xml \
        php82-xmlwriter \
        php82-pecl-redis

RUN ln -s /usr/bin/php82 /usr/bin/php

RUN php -r "copy('http://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

# WORKDIR /var/www/html
# RUN composer update

#    libzip-dev \
#    libpng-dev \
#    libjpeg-turbo-dev \
#    freetype-dev \
#    zip \
#    unzip \
#    git \
#    supervisor \
#    && docker-php-ext-configure gd --with-freetype --with-jpeg \
#    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip \
#    && apk add --update linux-headers \
#    # composer
#    && curl --output composer-setup.php https://getcomposer.org/installer \
#    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
#    && rm composer-setup.php

RUN mkdir /var/log/supervisord
COPY start /usr/local/bin/start
COPY php.ini /etc/php82/conf.d/99-docker.ini
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN chmod +x /usr/local/bin/start

EXPOSE 80

WORKDIR /var/www/html

ENTRYPOINT ["start"]