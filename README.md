## Docker

Переименовать файлы  
config/params-local-example.php --> config/params-local.php  
config/web-local-example..php --> config/web-local.php  
config/db-local-example.php -->  config/db-local.php

В файле .env необходимо поменять локальные порты, которые будет использовать контейнер на не занятые (либо оставить как
есть, если порты не заняты).  

Запускаем команды:  
~ docker-compose build  
~ docker-compose up -d

Приложение запущено

При первом запуске приложения необходимо сделать следующее:  
~ docker-compose exec php bash  
В открытой консоли докер-контейнера нужно выполнить следующие команды:  
~ composer install  
~ php yii migrate  

Сайт будет доступен по адресу localhost:8080 (либо другой порт, если он менялся в файле .env).  

После миграции создается пользователь username: admin, password: 123456