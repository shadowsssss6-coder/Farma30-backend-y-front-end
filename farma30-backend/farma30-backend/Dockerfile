FROM php:8.2-cli

# Dependencias del sistema y extensiones de PHP que Laravel necesita
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

# Render inyecta la variable $PORT en tiempo de ejecucion (normalmente 10000)
EXPOSE 10000

# Corre las migraciones y luego levanta el servidor, cada vez que arranca el contenedor
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
