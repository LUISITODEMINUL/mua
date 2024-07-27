# Usar la imagen oficial de Apache
FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    gcc make autoconf libc-dev pkg-config \
    libbz2-dev \
    libcurl4-openssl-dev \
    libxml2-dev \
    mariadb-client \
    libssl-dev \
    libldap-dev \
    libpcre3-dev \
    libmariadb-dev \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    zip \
    unzip \
    libicu-dev \
    libldap2-dev \
    libgd-dev \
    libpq-dev \
    git \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP
RUN docker-php-ext-install -j$(nproc) \
    mysqli pdo_mysql ctype soap session dom bcmath zip intl gd bz2 mbstring pgsql opcache sockets

# Instalar extensiones de PHP
RUN docker-php-ext-install -j$(nproc) \
    mysqli pdo_mysql ctype soap session dom bcmath zip intl gd bz2 mbstring pgsql opcache sockets

# Configurar Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/
RUN a2enmod rewrite setenvif && a2dissite * && a2disconf other-vhosts-access-log
RUN echo 'ServerName localhost' >> /etc/apache2/apache2.conf

# Copiar el contenido de la carpeta actual al directorio raíz del servidor web en el contenedor
COPY . /var/www/html/

# Exponer el puerto 80
# Exponer puertos (aunque esto es más informativo que necesario)
EXPOSE 80
EXPOSE 8080
EXPOSE 443

# Iniciar Apache en primer plano
CMD ["apache2ctl", "-D", "FOREGROUND"]