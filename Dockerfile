ARG PHP_VERSION=8.2
ARG NGINX_VERSION="latest"

FROM php:${PHP_VERSION}-fpm as app_php

# Ajouter un utilisateur non-root pour les opérations Composer
RUN adduser --disabled-password --gecos '' composeruser

# Installer les packages supplémentaires
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copier le fichier php.ini
COPY php.ini /usr/local/etc/php/

# Définir le répertoire de travail
WORKDIR /var/www/html

# Installer Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Copier le code source de l'application dans le conteneur
COPY --chown=composeruser:composeruser . /var/www/html

# Basculer vers l'utilisateur non-root
USER composeruser

# Installer les dépendances de l'application via Composer
RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-suggest --optimize-autoloader

# Revenir à l'utilisateur root
USER root

# Exposer le port 9000 pour PHP-FPM
EXPOSE 9000

# Démarrer PHP-FPM
CMD ["php-fpm"]


# Nginx stage
FROM nginx:${NGINX_VERSION} as nginx_app

# Copier la configuration Nginx
COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf

# Définir le répertoire de travail
WORKDIR /app/public
