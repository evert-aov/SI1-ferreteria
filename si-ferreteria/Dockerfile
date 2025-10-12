#FROM php:8.3-fpm

# Instalar dependencias del sistema
#RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    nodejs \
    npm

# Limpiar cache
#RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
#RUN docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
#WORKDIR /app

# Copiar archivos de dependencias
#COPY composer.json composer.lock package.json package-lock.json ./

# Instalar dependencias PHP
#RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Instalar dependencias Node
#RUN npm ci

# Copiar el resto del código
#COPY . .

# Build assets con Vite
#RUN npm run build

# Crear directorios necesarios y permisos
#RUN mkdir -p storage/framework/{sessions,views,cache,testing} \
    storage/logs \
    bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# Exponer puerto
#EXPOSE 8080

# Script de inicio
#COPY docker-entrypoint.sh /usr/local/bin/
#RUN chmod +x /usr/local/bin/docker-entrypoint.sh

#ENTRYPOINT ["docker-entrypoint.sh"]
