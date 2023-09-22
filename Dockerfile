FROM php:8.1.10

# Update packages
RUN apt update -y

#  Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install intl mysql
RUN apt install -y libicu-dev libpq-dev mariadb-client
RUN docker-php-ext-install intl pdo_mysql mysqli bcmath

# Install gd exif
RUN apt install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev
RUN docker-php-ext-install -j$(nproc) iconv gd exif
RUN docker-php-ext-configure gd

WORKDIR /var/www/html
ENTRYPOINT ["sh", "docker-entrypoint.sh"]
