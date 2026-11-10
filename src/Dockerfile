FROM php:8.3-apache

# Instalar la extensión necesaria para conectar con MySQL
RUN docker-php-ext-install mysqli

# Directorio de trabajo de Apache
WORKDIR /var/www/html