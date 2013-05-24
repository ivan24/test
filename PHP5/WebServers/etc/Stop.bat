@echo off
:: Программа для остановки всех серверов: Apache и MySQL.
: Остановка Apache.
Z:
cd \usr\local\apache
start apache.exe -k shutdown
: Остановка MySQL
cd \usr\local\mysql\bin
mysqladmin.exe -u root shutdown
: Добавьте сюда команды для остановки других серверов