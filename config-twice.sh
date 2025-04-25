sudo usermod -aG www-data $USER

sudo chown -R $USER:www-data ./app
# no laravel para criar as tabelas do sessons
# php artisan session:table
# php artisan migrate