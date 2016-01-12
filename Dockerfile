FROM php:5.5-apache

MAINTAINER Andreas Ek <andreas@aekab.se>

WORKDIR "/tmp"

COPY . /tmp/docker-bedrock

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
	mysql-client libmysqlclient-dev \
	git zip

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
    chmod +x wp-cli.phar && \
    mv wp-cli.phar /usr/local/bin/wp

RUN docker-php-ext-install mysqli zip mbstring

RUN pecl install xdebug-beta

RUN docker-php-ext-enable xdebug

RUN chmod +x /tmp/bin/docroot.sh

RUN bin/docroot.sh

WORKDIR "/var/www/html"

EXPOSE 80


