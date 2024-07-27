# Usar la imagen oficial de Apache
FROM php:7.4-apache

# Copiar el contenido de la carpeta actual al directorio raíz del servidor web en el contenedor
COPY . /var/www/html/

# Exponer el puerto 80
EXPOSE 80
EXPOSE 443
