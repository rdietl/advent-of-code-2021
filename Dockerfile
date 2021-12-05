FROM php:8

# Install system dependencies
RUN apt-get update

# Install PHP extensions
# add xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY entry.sh /usr/local/bin/
RUN chmod 777 /usr/local/bin/entry.sh

ENTRYPOINT ["/usr/local/bin/entry.sh"]

# Set working directory
WORKDIR /var/www/app
