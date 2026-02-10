#!/bin/sh
set -e

# Se Laravel não existir, cria
if [ ! -f "artisan" ]; then
    echo "🚀 Criando projeto Laravel..."

    composer create-project laravel/laravel . "^11.0"

    cp .env.example .env

    php artisan key:generate
fi

# Permissões
chown -R www-data:www-data || true
chmod -R 775 storage bootstrap/cache || true

exec php-fpm
