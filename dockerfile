# Версия
FROM php:8.1
# Обновление
RUN apt-get update
# Устанавливаем с подтверждением
RUN apt-get install -y sqlite3 libsqlite3-dev nodejs npm
# Обращаемся к сайту для установки композера
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
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
#CMD ["php", "rr", "serve"]
# При работе возникла ошибка rr файла, постарался запустить контейнер по таймеру, вручную пройдя все команды
CMD ["sleep", "1000000"]
#Увидел ошибку bash: rr: command not found
#---------------------------------------------------------------------------------------------------------------------- 
#Далее все описано командами, объяснение в скобках
#----------------------------------------------------------------------------------------------------------------------
# php rr serve (попытка динамически установить)
# ls -l /var/www/.rr.yaml (наличие и доступ)
# В гите по ссылке https://github.com/roadrunner-php/laravel-bridge попытался разобрать ошибку
# composer require spiral/roadrunner-laravel:* (все версии)
# php --ini (посмотрел конфигурационные файлы)
# composer require spiral/roadrunner-laravel:* -W --ignore-platform-req=ext-sockets (команда с форума для игнорирования платформ(ошибка в версии))
# apt install zip unzip php-zip (был один из вариантов решения)
# Попытался скачать архив с оф сайта rr, распаковать
# apt install wget (установил wget)
# wget https://github.com/roadrunner-server/roadrunner/releases/download/v2023.3.0/roadrunner-2023.3.0-linux-amd64.tar.gz
# tar -xvf roadrunner-2023.3.0-linux-amd64.tar.gz 
# cd roadrunner-2023.3.0-linux-amd64/ (сменил директорию)
# ./rr (проверил файл на наличие в директории)
# env (посмотрел окружение)
# cp ./rr /usr/bin/ (перекинул его для видимости из под всех)
# cd ..
# rr (проверил на наличие)
# rr serve (попытался выполнить выдало ошибку \/ )
# handle_serve_command: While parsing config: yaml: line 8: did not find expected key
# apt install nano (установил нано)
# nano ./.rr.yaml (попытался динамически пройти по параметрам)
# rr serve -c ./.rr.yaml (проверка)
# Далее вырезка history искал в чем мб ошибка
#   3  rr reset
#   4  nano ./.rr.yaml
#   5  rr serve -c ./.rr.yaml    
#   6  nano ./.rr.yaml
#   7  nano ./.rr-new.yaml       
#   8  rr serve -c ./.rr-new.yaml
#   9  nano ./.rr-new.yaml       
#  10  rr serve -c ./.rr-new.yaml
#  11  nano ./.rr-new.yaml       
#  12  rr serve -c ./.rr-new.yaml
#  13  nano ./.rr-new.yaml       
#  14  rr serve -c ./.rr-new.yaml
#  15  nano ./.rr-new.yaml
#  16  rr serve -c ./.rr-new.yaml
#  17  rr reset
#  18  rr reset -c ./.rr-new.yaml
#  19  rr serve -c ./.rr-new.yaml
# Резюмирую, на данный момент ошибка не устранена, моё предположение что ошибка в конфигурационном файле yaml тк некоторые
# ошибки ссылались на неправильный синтаксис файла, создал отдельный .rr-new.yaml для внесения пошаговых изменений изменения
# вносил динамически через nano:
#version: "3"
#server:
#    command: "php psr-worker.php"
# http:
#   address: 0.0.0.0:8081
#   max_request_size: 256
#   middleware: ["static", "headers", "gzip"]
#   headers:
#     response:
#       X-Powered-By: "RoadRunner"
#
#   static:
#     dir: "./public"
#     forbid: [".env", ".php"]