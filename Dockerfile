# Используем официальный образ Node.js
FROM node:19.5.0-alpine AS node

# Установка рабочей директории
WORKDIR /app

# Копирование зависимостей package.json и package-lock.json
COPY package*.json ./

# Установка зависимостей
RUN npm install

# Копирование остальных файлов проекта
COPY . .

# Используем официальный образ PHP
FROM php:8.1-apache

# Установка зависимостей для PHP
RUN docker-php-ext-install pdo pdo_mysql

# Копирование файлов проекта в контейнер
COPY --from=node /app /var/www/html

# Определение команды запуска приложения
CMD [ "apache2-foreground" ]