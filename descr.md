# Создаём .env файл из имеющегося
cp .env.example .env

docker build -t AppTest .

docker run -p 8081:8081 AppTest