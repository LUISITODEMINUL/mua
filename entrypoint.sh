#!/bin/bash

# Configurar la dirección PASV
if [ -z "$PASV_ADDRESS" ]; then
  export PASV_ADDRESS=$(curl -s http://checkip.amazonaws.com)
fi
sed -i "s/REPLACE_WITH_HOSTNAME/$PASV_ADDRESS/" /etc/vsftpd.conf

# Crear usuario y configurar contraseña
useradd -d /var/www/html ${FTP_USER}
echo "${FTP_USER}:${FTP_PASS}" | chpasswd
chown -R ${FTP_USER}:${FTP_USER} /var/www/html

# Iniciar vsftpd y Apache en primer plano
service vsftpd start
apache2ctl -D FOREGROUND
