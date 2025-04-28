sudo usermod -aG www-data $USER

sudo chown -R $USER:www-data ./app
