FROM php:8.2-apache

# Ativa mod_rewrite (opcional, mas recomendado)
RUN a2enmod rewrite

# Copia todos os arquivos do projeto para o Apache
COPY . /var/www/html/

# Permissões para permitir escrita no JSON
RUN chown -R www-data:www-data /var/www/html \
    && chmod 664 /var/www/html/registros_chamadas.json

EXPOSE 80
