FROM php:7.3-apache

ENV APP_HOME /var/www/html

RUN apt-get update && apt-get upgrade -y && apt-get install -y \
      procps \
      nano \
      wget \
      git \
      unzip \
      libicu-dev \
      zlib1g-dev \
      libxml2 \
      libxml2-dev \
      libreadline-dev \
      supervisor \
      cron \
      libzip-dev \
      librabbitmq-dev \
      apt-transport-https \
      ca-certificates \
      gnupg2 \
    libpng-dev \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install amqp xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-configure intl \
    && docker-php-ext-install \
      pdo_mysql \
      sockets \
      intl \
      opcache \
      zip \
    && docker-php-ext-enable amqp \
    && rm -rf /tmp/* \
    && rm -rf /var/list/apt/* \
    && rm -rf /var/lib/apt/lists/* \
    && apt-get clean

RUN a2dissite 000-default.conf
RUN rm -r $APP_HOME

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data
RUN chown -R www-data:www-data $APP_HOME

COPY ./docker/vhost.conf /etc/apache2/sites-available/vhost.conf
RUN a2ensite vhost.conf

COPY ./docker/php.ini /usr/local/etc/php/php.ini

RUN a2enmod rewrite

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN chmod +x /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
