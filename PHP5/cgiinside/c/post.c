// Получение данных POST
#include <stdio.h>
#include <stdlib.h>

void main(void) {
  // извлекаем значения переменных окружения
  char *RemoteAddr = getenv("REMOTE_ADDR");
  char *ContentLength = getenv("CONTENT_LENGTH");
  char *QueryString = getenv("QUERY_STRING");
  // вычисляем длину данных - переводим строку в число
  int NumBytes = atoi(ContentLength);
  // выделяем в свободной памяти буфер нужного размера
  char *Data = (char *)malloc(NumBytes + 1);
  // читаем данные из стандартного потока ввода
  fread(Data, 1, NumBytes, stdin);
  // добавляем нулевой код в конец строки
  // (в Си нулевой код сигнализирует о конце строки)
  Data[NumBytes] = 0;
  // выводим заголовок
  printf("Content-type: text/html\n\n");
  // выводим документ
  printf("<html><body>");
  printf("<h1>Здравствуйте. Мы знаем о вас все!</h1>");
  printf("Ваш IP-адрес: %s<br>",RemoteAddr);
  printf("Количество байтов данных: %d<br>",NumBytes);
  printf("Вот параметры, которые Вы указали: %s<br>",Data);
  printf("А вот то, что мы получили через URL: %s",
    QueryString);
  printf("</body></html>");
}
