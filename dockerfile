# Usa a imagem oficial do PHP com Apache integrado
FROM php:8.2-apache

# Instala as extensões do PHP necessárias para conexão com bancos de dados MySQL/MariaDB
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Ativa o módulo rewrite do Apache
RUN a2enmod rewrite

# Copia os arquivos do projeto
COPY . /var/www/html/

# Permissões do Apache
RUN chown -R www-data:www-data /var/www/html

# Porta do Apache
EXPOSE 80