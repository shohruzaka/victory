#!/bin/bash
set -e

echo "Deploy boshlandi..."

cd /var/www/victory

# 1. Vaqtincha saytni yopish (Foydalanuvchilarga chiroyli "Tez orada qaytamiz" sahifasi chiqadi)
php artisan down --refresh=15 || true

# 2. Kodni GitHub-dan tortish
git pull origin main

# 3. PHP paketlarini yangilash
composer install --no-dev --optimize-autoloader

# 4. Ma'lumotlar bazasini yangilash
php artisan migrate --force

# 5. Frontend paketlarini yangilash va build qilish
npm install
npm run build

# 6. Keshni tozalash va optimallashtirish
php artisan optimize:clear
php artisan optimize

# 7. Fon rejimdagi xizmatlarni yangilash (Reverb, Workers)
supervisorctl restart all || true

# 8. Saytni qayta ochish
php artisan up

echo "Deploy muvaffaqiyatli yakunlandi!"
