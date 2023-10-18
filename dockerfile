# Версия
FROM php:8.2
# Обновление
RUN apt-get update
# Устанавливаем с подтверждением
RUN apt-get install -y --fix-missing sqlite3 libsqlite3-dev nodejs npm 
# После ошибки выдаваемой при установки, провожу обновление, установку
RUN apt-get update && \
	apt-get install -y libzip-dev && \
	docker-php-ext-install zip
# Обращаемся к сайту для установки композера
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
    mv composer.phar /usr/local/bin/composer
# Копируем все в /var/www
COPY . /var/www
# Устанавливаем его рабочей директорией
WORKDIR /var/www
# Устанавливаем композер
RUN composer install --no-interaction --no-dev --optimize-autoloader
# Устанавливаем yarn
RUN npm install --global yarn
# Устанавливаем зависимости
RUN yarn install
# Копируем .rr.yaml в рабочую директорию
COPY .rr.yaml /var/www/.rr.yaml
# Открываем порт 8001
EXPOSE 8001
# Запускаем CMD
CMD ["php", "rr", "serve"]
