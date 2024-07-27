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
    openssh-server \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP
RUN docker-php-ext-install -j$(nproc) \
    mysqli pdo_mysql ctype soap session dom bcmath zip intl gd bz2 mbstring pgsql opcache sockets

# Configurar Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/
RUN a2enmod rewrite setenvif && a2dissite * && a2disconf other-vhosts-access-log
RUN echo 'ServerName localhost' >> /etc/apache2/apache2.conf

# Configurar y habilitar SSH
RUN mkdir /var/run/sshd

# Crear usuario y configurar SSH
RUN useradd -m ${SFTP_USER} && echo "${SFTP_USER}:${SFTP_PASS}" | chpasswd
RUN mkdir -p /home/${SFTP_USER}/.ssh && chown -R ${SFTP_USER}:${SFTP_USER} /home/${SFTP_USER}/.ssh

# Copiar el contenido de la carpeta actual al directorio raíz del servidor web en el contenedor
COPY . /var/www/html/

# Exponer el puerto 80, 8080, 443 y 22 para SSH
EXPOSE 80
EXPOSE 8080
EXPOSE 443
EXPOSE 22

# Iniciar Apache y SSH en primer plano
CMD ["/bin/bash", "-c", "service ssh start && apache2ctl -D FOREGROUND"]