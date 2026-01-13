# Utilisation de l'image officielle PHP 8.2 avec Apache
FROM php:8.2-apache

# 1. Activation du module de réécriture d'URL d'Apache (nécessaire pour le routage)
RUN a2enmod rewrite

# 2. Configuration du DocumentRoot pour pointer vers le sous-dossier /public
# Cela garantit que vos fichiers sensibles (.env, dossiers classes) ne sont pas accessibles par URL
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 3. Autoriser les fichiers .htaccess en passant AllowOverride de None à All
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# 4. Mise à jour des paquets et installation des dépendances système nécessaires
# libicu-dev : requis pour l'extension intl (dates en français)
# libzip-dev : requis pour l'extension zip (utilisé par Composer)
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    unzip \
    git \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 5. Configuration et installation des extensions PHP
# intl : pour le formatage des dates (IntlDateFormatter)
# pdo_mysql : pour la connexion à votre base de données MySQL
# zip : pour permettre à Composer de gérer les paquets compressés
RUN docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo_mysql zip

# Installations des extension pour l'utilisation de MySQL
# RUN docker-php-ext-install pdo pdo_mysql mysqli

# 6. Installation de Composer (récupéré depuis l'image officielle la plus récente)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 7. Définition du dossier de travail à l'intérieur du conteneur
WORKDIR /var/www/html

# 8. Copie du fichier composer.json pour installer les dépendances
# On le fait avant de copier tout le projet pour profiter du cache Docker (optimisation du cache Docker)
COPY composer.json ./
COPY composer.lock ./

# 9. Installation des dépendances sans exécuter les scripts et sans générer l'autoloader final
RUN composer install --no-interaction --no-scripts --no-autoloader

# 10. Copie de l'intégralité de votre projet dans le conteneur
COPY . .

# 11. Attribution des droits de propriété au serveur web (www-data)
# Indispensable pour que PHP puisse écrire dans le .env ou dans le dossier uploads
RUN chown -R www-data:www-data /var/www/html

# 12. Génération de l'autoloader optimisé de Composer
RUN composer dump-autoload --optimize

