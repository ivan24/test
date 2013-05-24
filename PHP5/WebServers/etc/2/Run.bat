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
: Добавьте сюда команды для запуска других серверов