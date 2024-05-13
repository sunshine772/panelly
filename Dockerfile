# Usar la imagen base de PHP con Apache
FROM php:8.1-apache

# Argumentos definidos en docker-compose.yml
ARG user
ARG uid

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Limpiar la caché
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Obtener el último Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar node y npm
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash
RUN apt-get update && apt-get -y install nodejs 

# Establecer el directorio de trabajo
WORKDIR /var/www

# Instalar la extensión GD
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Establecer el directorio de trabajo para Laravel
WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . .

# Modificar la configuración php.ini
RUN touch /usr/local/etc/php/conf.d/uploads.ini \
    && echo "upload_max_filesize = 10M;" >> /usr/local/etc/php/conf.d/uploads.ini

# Servir la aplicación
RUN composer update
RUN npm install

# Iniciar la aplicación
CMD php artisan migrate --force && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=$PORT
