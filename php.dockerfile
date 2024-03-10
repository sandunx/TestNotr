FROM php:8.1-fpm

#RUN touch /var/log/error_log

#ADD ./php/www.conf /usr/local/etc/php-fpm.d/www.conf

#RUN addgroup -gid 1000 wp && adduser -gid 1000 -shell /bin/sh -disabled-login wp
#
#RUN mkdir -p /var/www/html
##
#RUN chown wp:wp /var/www/html
#
WORKDIR /var/www/html

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

#RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar

#RUN chmod +x wp-cli.phar && mv wp-cli.phar /usr/local/bin/wpsr/local/bin/wp