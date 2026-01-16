# ------------------------------------------------------------
# Image officielle PHP 8.2 avec Apache intégré
# → Apache sert les pages
# → PHP exécute le backend
# ------------------------------------------------------------
FROM php:8.2-apache


# ------------------------------------------------------------
# 1. Activation du module mod_rewrite d’Apache
# Indispensable pour :
# - le routing via .htaccess
# - les URLs propres (ex: /votes/waiting)
# Sans cela, Apache renverra des 404
# ------------------------------------------------------------
RUN a2enmod rewrite


# ------------------------------------------------------------
# 2. Installation des dépendances système nécessaires
# libicu-dev  : extension PHP intl (dates, formats)
# libzip-dev  : extension PHP zip (Composer)
# unzip/git   : nécessaires pour Composer
# ------------------------------------------------------------
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    unzip \
    git \
    && apt-get clean && rm -rf /var/lib/apt/lists/*


# ------------------------------------------------------------
# 3. Installation des extensions PHP
# intl       : gestion des dates/locale
# pdo_mysql  : accès base MySQL (OBLIGATOIRE)
# zip        : support archives Composer
# ------------------------------------------------------------
RUN docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo_mysql zip


# ------------------------------------------------------------
# 4. Installation de Composer
# On récupère l’exécutable depuis l’image officielle Composer
# ------------------------------------------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


# ------------------------------------------------------------
# 5. Copie de la configuration Apache personnalisée
# Ce fichier définit :
# - le DocumentRoot
# - AllowOverride All (autoriser .htaccess)
# ------------------------------------------------------------
COPY apache.conf /etc/apache2/sites-available/000-default.conf

COPY php.ini /usr/local/etc/php/php.ini

# ------------------------------------------------------------
# 6. Copie de l’intégralité du projet PHP dans le conteneur
# Le code sera accessible dans /var/www/html
# ------------------------------------------------------------
COPY . /var/www/html


# ------------------------------------------------------------
# 7. Attribution des droits au serveur web
# www-data = utilisateur Apache
# Indispensable pour :
# - sessions PHP
# - logs
# - uploads éventuels
# ------------------------------------------------------------
RUN chown -R www-data:www-data /var/www/html

RUN chown -R www-data:www-data /var/www/html/sessions
RUN chmod -R 770 /var/www/html/sessions


# ------------------------------------------------------------
# 8. Définition du dossier de travail
# Toutes les commandes suivantes s’exécuteront ici
# ------------------------------------------------------------
WORKDIR /var/www/html


# ------------------------------------------------------------
# 9. Installation des dépendances PHP via Composer
# --no-interaction     : pas de questions
# --optimize-autoloader: autoloader optimisé (production)
# ------------------------------------------------------------
RUN composer install --no-interaction --optimize-autoloader
