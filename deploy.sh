#!/bin/bash
set -e

echo "Deploy boshlandi..."

cd /var/www/victory

# 1. Kodni GitHub-dan tortish
git pull origin main

# 2. PHP paketlarini yangilash
composer install --no-dev --optimize-autoloader

# 3. Ma'lumotlar bazasini yangilash
php artisan migrate --force

# 4. Frontend paketlarini yangilash va build qilish
npm install
npm run build

# 5. Keshni tozalash va optimallashtirish
php artisan optimize

# 6. Fon rejimdagi xizmatlarni yangilash (Reverb, Workers)
supervisorctl restart all

echo "Deploy muvaffaqiyatli yakunlandi!"
