@echo off
:: Программа для запуска всех серверов: Apache и MySQL.
call Boot.bat
Z:
: Установка пути поиска php.ini.
set PHPRC=\usr\local\php5
set PATH=%PHPRC%;%PATH%
: Запуск Apache.
cd \usr\local\apache
start apache.exe
: Запуск MySQL.
cd \usr\local\mysql\bin
: Следующая команда НА ОДНОЙ СТРОКЕ!
start mysqld-max.exe --defaults-file=\usr\local\mysql\data\my.cnf --user=root --standalone
: Добавьте сюда команды для запуска других серверов