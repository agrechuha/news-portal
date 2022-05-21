При первом запуске приложения необходимо сделать следующее: composer install  

Создать БД в Mysql, изменить конфигурацию базы данных в файле config/db-local-example.php и переименовать этот файл в db-local.php  
Переименовать файлы  
config/params-local-example.php --> config/params-local.php  
config/web-local-example..php --> config/web-local.php  

Применить миграцию, выполнить команду из корня приложения php yii migrate  

Запустить сервер, выполнив команду из корня php -S localhost:8000 -t web/  
Сайт будет доступен по адресу localhost:8000  

После миграции создается пользователь username: admin, password: 123456