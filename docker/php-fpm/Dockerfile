FROM php:7.4-fpm-alpine

RUN echo $DATABASE_URL

COPY wait-for-it.sh /usr/bin/wait-for-it

RUN chmod +x /usr/bin/wait-for-it

RUN apk --update --no-cache add git bash

RUN apk add --no-cache wget

RUN wget https://get.symfony.com/cli/installer -O - | bash

RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN docker-php-ext-install pdo_mysql

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

CMD composer install ; php-fpm

EXPOSE 9000