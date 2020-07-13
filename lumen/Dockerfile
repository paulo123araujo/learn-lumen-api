FROM php:7.4-fpm

WORKDIR /var/www

COPY . /var/www

RUN apt-get update && apt-get install -y \
    build-essential \
    libonig-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libxml2-dev \
    libzip-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    nodejs \
    npm

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install mysqli pdo tokenizer xml pcntl
RUN docker-php-ext-install pdo_mysql zip exif
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY --chown=www:www . /var/www

USER www

EXPOSE 8000
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
