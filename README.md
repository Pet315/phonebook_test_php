To work with the project, you need to:

1. Run the database.sql file
2. Run the composer install command
3. Check for mbstring using the php -m | findstr mbstring command
4. If it is not present, comment out extension=mbstring in php.ini
5. Run the server php -S localhost:8000 -t public
