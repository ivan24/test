@echo off
:: Программа для запуска всех серверов: Apache и MySQL.
call Boot.bat
Z:
: Запуск Apache.
cd \usr\local\apache
start apache.exe
: Добавьте сюда команды для запуска других серверов
