FROM php:8.3-fpm

# Instala as dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install exif \
    && docker-php-ext-install zip \
    && yes '' | pecl install redis \
    && docker-php-ext-enable redis

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#copia o arquivo de configuração do nginx
COPY nginx/default.conf /etc/nginx/conf.d/default.conf

# Define o diretório de trabalho
WORKDIR /var/www/html

# Instalar o Nginx
RUN apt-get update && apt-get install -y nginx && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Expor a porta 80 para o Nginx
EXPOSE 80
# Expondo a porta 9000
EXPOSE 9000

# Ajustar o UID e GID do www-data para corresponder ao usuário do host
ARG UID=1000
ARG GID=1000
RUN usermod -u $UID www-data && groupmod -g $GID www-data

# Inicia o PHP-FPM e o Nginx
CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]