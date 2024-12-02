# Usar una imagen oficial de PHP con Apache
FROM php:8.1-apache

# Copiar todos los archivos del proyecto al contenedor
COPY . /var/www/html/

# Dar permisos adecuados
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Instalar extensiones necesarias (por ejemplo, mysqli y pdo_mysql)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitar el módulo rewrite de Apache
RUN a2enmod rewrite

# Exponer el puerto 80
EXPOSE 80

# Iniciar Apache
CMD ["apache2-foreground"]
