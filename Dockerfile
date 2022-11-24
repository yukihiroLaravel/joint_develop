FROM nginx:1.18-alpine as nginx
FROM php:7.4-fpm-alpine
SHELL ["/bin/ash", "-oeux", "pipefail", "-c"]

# timezone environment
ENV TZ="Asia/Tokyo" \
  # locale
  LANG="ja_JP.UTF-8" \
  LANGUAGE="ja_JP:ja" \
  LC_ALL="ja_JP.UTF-8" \
  # composer environment
  COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

RUN apk update && apk upgrade
RUN apk add --no-cache git icu-dev libzip-dev libpng-dev zip unzip supervisor tzdata musl musl-utils musl-locales vim bash \
  && rm -rf /var/cache/apk/*

RUN set -ex \
	&& apk --no-cache add postgresql-libs postgresql-dev \
	&& docker-php-ext-install pgsql pdo_pgsql \
	&& apk del postgresql-dev

RUN mkdir /var/run/php-fpm
RUN mkdir /var/log/nginx /var/cache/nginx
RUN docker-php-ext-install intl zip bcmath gd
RUN composer config -g process-timeout 3600
RUN composer config -g repos.packagist composer https://packagist.org

COPY --from=nginx /etc/nginx /etc/nginx
COPY --from=nginx /usr/lib /usr/lib
COPY --from=nginx /usr/sbin /usr/sbin

COPY ./docker/php/php-fpm.d/zzz-www.conf /usr/local/etc/php-fpm.d/zzz-www.conf
COPY ./docker/php/php.ini /usr/local/etc/php/php.ini
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
COPY ./docker/supervisor/app.ini /etc/supervisor.d/app.ini

WORKDIR /app

COPY ./ /app/

RUN chown -R 755 /app/
RUN chmod -R 777 /app/storage/
RUN chmod 644 /app/public/.htaccess
RUN chmod a+x /app/start.sh

EXPOSE 80


CMD ["/app/start.sh"]
