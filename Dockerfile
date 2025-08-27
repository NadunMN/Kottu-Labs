FROM php:8.2-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP packages
RUN composer global require vlucas/phpdotenv phpmailer/phpmailer

# Copy project files
COPY . .

EXPOSE 8082

CMD ["php", "-S", "0.0.0.0:8082", "-t", "public"]
