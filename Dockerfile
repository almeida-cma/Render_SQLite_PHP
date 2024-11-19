# Usar uma imagem base do PHP com Apache
FROM php:8.2-apache

# Instalar a extensão SQLite3 para PHP
RUN docker-php-ext-install pdo pdo_sqlite

# Ativar o mod_rewrite do Apache
RUN a2enmod rewrite

# Configurar o diretório de trabalho
WORKDIR /var/www/html

# Copiar os arquivos do projeto para o diretório do container
COPY . /var/www/html/

# Ajustar permissões para o Apache poder acessar os arquivos
RUN chown -R www-data:www-data /var/www/html

# Expor a porta 80
EXPOSE 80

# Iniciar o Apache em primeiro plano
CMD ["apache2-foreground"]
