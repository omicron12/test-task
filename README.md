## Стек проекта:

Проект построен на основе фреймворка Laravel 10.x

Используется application server RoadRunner, он интегрирован в проект. 

В качестве СУБД используется SQlite3

### Системные требования:

- php 8.1+
- sqlite3 3.31+
- nodejs 18.0+
- composer v2
- npm или yarn

## Задача:

Данный код необходимо упаковать в Docker контейнер. Необходимо внести в репозиторий такие правки, при которых можно будет склонировать код на любой сервер, сделать build образа, а после выполнения run и получить готовый контейнер, отвечающий на запросы и выполняющий базовый функционал приложения.

### Правила выполнения:

1. Зарегистрировать учётную запись на GitHub или использовать существующую. 
2. Сделать fork репозитория. 
3. Склонировать репозиторий
4. Создать ветку test_<Инициалы> (например Для Иванова И.И - InanovII)
5. Смержить master в созданную ветку. 
6. Переключится на созданную ветку. Работать в созданной ветке, все правки и коммиты вносить туда. 
7. По окончании работ сделать push всех изменений. 
8. Создать pull request в основной репозиторий. 

### Дополнительно:

1. Сведения о стеке и требованиях необходимо найти самостоятельно. Разрешается использование документации, поисковиков, любые источники информации.
2. Разрешается использование любых контейнеров из DockerHub (alpine, ubuntu, etc)
3. В проекте приложены .env.example и .rr.local.yml. Допускается внесение правок, если предполагается, что в них содержаться ошибки и\или чего-то не хватает. Правки в код недопускаются.
4. Допускается создание любого необходимого количества файлов и каталогов для завершения задания.
5. Допускается задавать уточняющие вопросы, если описанного в данном описании недостаточно.  
6. Конфигурации обязательно должны содержать комментарии с описанием проделанных действий. 
7. Если необходимо, можно приложить DESCRIPTION.md с описанием, как необходимо запустить проект, для получения итогового результата. 

## Ожидаемый результат

Репозиторий будет склонирован, контейер запущен согласно приложенному описанию и проверен на работоспособность.

- Отличным вариантом будет получение standalone контейнера с приложением.

- Хорошим вариантом будет создание любого работающего варианта. 

- Удовлетворительным вариантом является собирающийся контейнер, не дающий полноценно работающее приложение. 

- Неудовлетворительным вариантом является невозможность собрать контейнер или его нерабочее состояние. 