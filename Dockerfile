# Use the official PHP image with FPM
FROM php:8.2-fpm

# Add a non-root user for Composer operations
RUN useradd -m composeruser

# Install additional packages
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/html

# Install Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Copy application source code into the container
COPY --chown=composeruser:composeruser . /var/www/html

# Switch to the non-root user
USER composeruser

# Install application dependencies via Composer
RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-suggest --optimize-autoloader

# Switch back to the root user
USER root

# Expose port 9000 for PHP-FPM
EXPOSE 9000

