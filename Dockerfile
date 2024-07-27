# Usar la imagen oficial de Apache
FROM php:8.1-apache

# Configurar Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/
RUN a2enmod rewrite setenvif && a2dissite * && a2disconf other-vhosts-access-log
RUN echo 'ServerName localhost' >> /etc/apache2/apache2.conf


# Copiar el contenido de la carpeta actual al directorio raíz del servidor web en el contenedor
COPY . /var/www/html/

# Exponer el puerto 80
# Exponer puertos (aunque esto es más informativo que necesario)
EXPOSE 80
EXPOSE 8080
EXPOSE 443

# Añadir la configuración para que Apache escuche en el puerto proporcionado por Railway
RUN sed -i 's/80/${PORT}/' /etc/apache2/sites-available/000-default.conf

# Iniciar Apache en primer plano utilizando la variable de entorno PORT
CMD ["sh", "-c", "echo \"<VirtualHost *:${PORT}>\n\tServerName localhost\n\tDocumentRoot /var/www/html\n\n\t<Directory /var/www/html>\n\t\tOptions Indexes FollowSymLinks\n\t\tAllowOverride All\n\t\tRequire all granted\n\t</Directory>\n\n\tErrorLog ${APACHE_LOG_DIR}/error.log\n\tCustomLog ${APACHE_LOG_DIR}/access.log combined\n</VirtualHost>\" > /etc/apache2/sites-available/000-default.conf && apache2ctl -D FOREGROUND"]

