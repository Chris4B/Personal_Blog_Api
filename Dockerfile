# Utiliser l'image officelle de Php avec FPM

FROM php:8.2-fpm

# Installer les dépendances nécessaires 

RUN apt-get update && apt-get install -y \
    git \
    unizp \
    libpq-dev \
    libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Installer composer 
COPY --from=composer:lastest /usr/bin/composer /usr/bin/composer

# Copier le code source de l'application 
COPY .  /var/www/html

# Définir le répertoire de travail
WORKDIR /var/www/html

#Installer les dépendances
RUN composer install

#donner les permissions nécessaires
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/var

# Exposer le port 9000 pour PHP-FPM
EXPOSE 9000