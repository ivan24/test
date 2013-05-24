// ѕростой сценарий, использующий Cookies.
#include <stdio.h>
#include <stdlib.h>

// начало программы
void main() {
  // ¬ременный буфер
  char Buf[1000];
  // получаем в переменную Cook значение Cookies
  char *Cook = getenv("HTTP_COOKIE");
  // пропускаем в ней 5 первых символов ("cook="), если она не пуста€ -
  // получим как раз значение Cookie, которое мы установили ранее
  // (см. ниже).
  Cook += 5;  // сдвинули указатель на 5 символов вперед по строке
  // получаем переменную QUERY_STRING
  char *Query = getenv("QUERY_STRING");
  // провер€ем, заданы ли параметры у сценари€ - если да, то
  // пользователь, очевидно, ввел свое им€ или нажал кнопку,
  // в противном случае он просто запустил сценарий без параметров
  if(strcmp(Query, "")) { // строка не пуста€?
    // копируем в буфер значение QUERY_STRING,
    // пропуска€ первые 5 символов (часть "name=") -
    // получим как раз текст пользовател€
    strcpy(Buf, Query + 5);
    // ѕользователь ввел им€ - значит, нужно установить Cookie 
    printf("Set-cookie: cook=%s; "
           "expires=Friday,31-Dec-01 23:59:59 GMT", Buf); 
    // “еперь это - новое значение Cookie
    Cook=Buf;
  }
  // выводим страницу с формой
  printf("Content-type: text/html\n\n");
  printf("<html><body>\n");
  // если им€ задано (не пуста€ строка), приветствие
  if(strcmp(Cook, ""))
    printf("<h1>ѕривет, %s!</h1>\n",Cook);
  // продолжаем
  printf("<form action=/cgi-bin/script.cgi method=get>\n");
  printf("¬аше им€: ");
  printf("<input type=text name=name value='%s'>\n",Cook);
  printf("<input type=submit value='ќтправить'>\n");
  printf("</form>\n");
  printf("</body></html>");
}
