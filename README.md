Для роботи з проектом необхідно:

1. Запустити файл database.sql
2. Запустити команду composer install
3. Перевірити наявність mbstring за допомогою команди php -m | findstr mbstring
4. У разі відсутності розкоментувати extension=mbstring в php.ini
5. Запустити сервер php -S localhost:8000 -t public
