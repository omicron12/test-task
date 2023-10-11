# Указываем базовый образ
FROM php:8.1

# Устанавливаем необходимые зависимости
RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    nodejs \
    npm

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Копируем и устанавливаем зависимости проекта
COPY . /var/www
WORKDIR /var/www

RUN composer install --no-interaction --no-dev --optimize-autoloader

# Устанавливаем Node.js зависимости
RUN npm install --global yarn

# Устанавливаем зависимости проекта с помощью Yarn
RUN yarn install

# Собираем и запускаем фронтенд проекта в режиме продакшн
RUN yarn run prod

# Конфигурируем RoadRunner
COPY .rr.yaml /var/www/.rr.yaml

# Открываем порт для входящих запросов
EXPOSE 8001

# Запускаем RoadRunner
CMD ["php", "rr", "serve"]