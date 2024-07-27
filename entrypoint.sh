#!/bin/bash

# Crear usuario y configurar contraseña
useradd -m ${SFTP_USER}
echo "${SFTP_USER}:${SFTP_PASS}" | chpasswd
mkdir -p /home/${SFTP_USER}/.ssh
chown -R ${SFTP_USER}:${SFTP_USER} /home/${SFTP_USER}/ftp



# Iniciar vsftpd y Apache en primer plano
service vsftpd start
apache2ctl -D FOREGROUND

