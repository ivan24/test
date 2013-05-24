// ѕолучение POST-данных с URL-декодированием.
#include <stdio.h>
#include <stdlib.h>
#include "urldecode.c"

void main(void) {
  // получаем значени€ переменных окружени€
  char *RemoteAddr = getenv("REMOTE_ADDR");
  char *ContentLength = getenv("CONTENT_LENGTH");
  //!! выдел€ем пам€ть дл€ буфера QUERY_STRING
  char *QueryString = malloc(strlen(getenv("QUERY_STRING")) + 1);
  //!! копируем QUERY_STRING в созданный буфер 
  strcpy(QueryString, getenv("QUERY_STRING"));
  // декодируем QUERY_STRING
  UrlDecode(QueryString);
  // вычисл€ем количество байтов данных - переводим строку в число
  int NumBytes = atoi(ContentLength);
  // выдел€ем в свободной пам€ти буфер нужного размера
  char *Data = (char*)malloc(NumBytes + 1);
  // читаем данные из стандартного потока ввода
  fread(Data, 1, NumBytes, stdin);
  // добавл€ем нулевой код в конец строки
  // (в —и нулевой код сигнализирует о конце строки)
  Data[NumBytes] = 0;
  // декодируем данные (хоть это и не совсем осмысленно, но 
  // выполн€ем сразу дл€ всех POST-данных, не разбива€ их на 
  // параметры)
  UrlDecode(Data);
  // выводим заголовок
  printf("Content-type: text/html\n\n");
  // выводим документ
  printf("<html><body>");
  printf("<h1>«дравствуйте. ћы знаем о ¬ас все!</h1>");
  printf("¬аш IP-адрес: %s<br>",RemoteAddr);
  printf(" оличество байтов данных: %d<br>", NumBytes);
  printf("¬от параметры, которые ¬ы указали: %s<br>",Data);
  printf("ј вот то, что мы получили через URL: %s",
    QueryString);
  printf("</body></html>");
}
