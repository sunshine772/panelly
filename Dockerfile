# Primero, el Dockerfile para la construcción de assets y dependencias de PHP Composer:
# Este Dockerfile está enfocado en la construcción de assets y dependencias de PHP Composer.

# Utiliza la imagen oficial de Composer para instalar las dependencias de PHP.
FROM composer:2.0 as vendor

# Etiqueta la imagen como composer:2
LABEL image=composer:2

# Copia los archivos relacionados con la base de datos
COPY database/ /app/database/

# Copia los archivos composer.* al contenedor
COPY composer.* /app/

# Instala las dependencias de PHP
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader

# A continuación, el Dockerfile para la construcción de assets de frontend:
# Este Dockerfile se centra en la construcción de assets de frontend.

# Utiliza la imagen oficial de Node.js para compilar assets de frontend.
FROM node:14-alpine as frontend

# Etiqueta la imagen como node:14
LABEL image=node:14

# Crea el directorio público en el contenedor
RUN mkdir -p /app/public

# Copia los archivos package.json, package-lock.json y webpack.mix.js al contenedor
COPY package.json package-lock.json webpack.mix.js /app/

# Copia los archivos JavaScript fuente
COPY resources/ /app/resources/

# Establece el directorio de trabajo en /app
WORKDIR /app

# Instala las dependencias de Node.js y compila los assets
RUN npm ci && npm run prod

# Finalmente, el Dockerfile principal que construye la imagen final del proyecto Laravel:
# Este Dockerfile construye la imagen final del proyecto Laravel utilizando las dependencias y assets compilados en los pasos anteriores.

# Utiliza la imagen oficial de PHP con Apache
FROM php:8.1-apache

# Establece la variable de entorno TZ para la zona horaria
ENV TZ=Asia/Kuala_Lumpur

# Crea un enlace simbólico para establecer la zona horaria
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Establece el directorio raíz de Apache para que apunte a /var/www/html/public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Instala las extensiones de PHP necesarias
RUN docker-php-ext-install pdo_mysql bcmath pcntl posix \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install ldap zip \
    && apt-get update \
    && apt-get install -y supervisor libldap2-dev nano libzip-dev zip mariadb-client \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/

# Habilita los módulos de Apache
RUN a2enmod rewrite headers

# Reinicia el servicio de Apache
RUN service apache2 restart

# Copia el archivo de configuración de supervisord
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copia el archivo de configuración de LDAP
COPY docker/ldap.conf /etc/ldap/ldap.conf

# Copia los archivos de configuración de PHP
COPY docker/*.ini /usr/local/etc/php/conf.d/

# Copia los archivos de dependencias de Composer del contenedor 'vendor'
COPY --from=vendor /app/vendor/ /var/www/html/vendor/

# Copia los archivos de assets de frontend del contenedor 'frontend'
COPY --from=frontend /app/public/js/ /var/www/html/public/js/
COPY --from=frontend /app/index.js /var/www/html/index.js
COPY --from=frontend /app/mix-manifest.json /var/www/html/mix-manifest.json

# Copia el resto de los archivos del proyecto al directorio /var/www/html en el contenedor
COPY --chown=www-data:www-data . /var/www/html

# CMD predeterminado para iniciar supervisord
CMD ["/usr/bin/supervisord"]
