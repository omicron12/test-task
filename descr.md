# Создаём .env файл из имеющегося
cp .env.example .env

docker build -t TestRR .

docker run -p 8081:8081 AppTest