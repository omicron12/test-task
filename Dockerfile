# Указываем базовый образ
FROM php:8.1-apache

# Устанавливаем необходимые зависимости
RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    nodejs \
    npm \
    zip \
    unzip

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Устанавливаем RoadRunner
RUN curl -L https://github.com/spiral/roadrunner/releases/download/v2023.3.0/roadrunner-2023.3.0-linux-amd64.tar.gz | tar xvz && \
    mv roadrunner-2023.3.0-linux-amd64/rr /usr/local/bin/rr && \
    chmod +x /usr/local/bin/rr

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

# Убеждаемся, что rr доступен в PATH
ENV PATH="/var/www/vendor/bin:${PATH}"

# Открываем порт для входящих запросов
EXPOSE 8081

# Запускаем RoadRunner
CMD ["/usr/local/bin/rr", "serve"]