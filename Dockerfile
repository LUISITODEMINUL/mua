# Usar la imagen oficial de Apache
FROM php:8.1-apache

# Actualizar e instalar dependencias
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
    vsftpd \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP
RUN docker-php-ext-install -j$(nproc) \
    mysqli pdo_mysql ctype soap session dom bcmath zip intl gd bz2 mbstring pgsql opcache sockets

# Configurar Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/
RUN a2enmod rewrite setenvif && a2dissite * && a2disconf other-vhosts-access-log
RUN echo 'ServerName localhost' >> /etc/apache2/apache2.conf

# Configurar y habilitar FTP
COPY vsftpd.conf /etc/vsftpd.conf

# Copiar el script de entrada
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Copiar el contenido de la carpeta actual al directorio raíz del servidor web en el contenedor
COPY . /var/www/html/

# Exponer el puerto 80, 8080, 443, 21 y el rango de puertos pasivos
EXPOSE 80
EXPOSE 8080
EXPOSE 443
EXPOSE 21
EXPOSE 10000-10100

# Configurar el script de entrada
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
