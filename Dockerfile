#FROM php:8.2-apache
# Utilisation de PHP 8.3 (standard en 2026)
FROM php:8.2-apache

# 1. Active le module de réécriture d'Apache
RUN a2enmod rewrite

# Change le DocumentRoot d'Apache vers le dossier /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf


# 2. Autorise l'utilisation du .htaccess (écrase la config par défaut)
#RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

#FROM php:8.3-fpm

# Installations des extension pour l'utilisation de MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Installation des dépendances système pour Composer et MySQL
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql zip

# Installation de Composer via l'image officielle
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définition du dossier de travail
WORKDIR /var/www/html

# Copie des fichiers de configuration Composer
COPY composer.json ./

# Installation des dépendances et génération de l'autoloader
# On utilise --no-scripts pour éviter les erreurs si les classes ne sont pas encore là
RUN composer install --no-interaction --no-scripts --no-autoloader

# Copie de tout le projet (y compris vos scripts à la racine)
COPY . .

# Génération finale de l'autoloader
RUN composer dump-autoload --optimize
