// Работа с переменными окружения
#include <stdio.h>  // Включаем функции ввода/вывода
#include <stdlib.h> // Включаем функцию getenv()

void main(void) {
  // получаем значение переменной окружения REMOTE_ADDR
  char *RemoteAddr = getenv("REMOTE_ADDR");
  // ... и еще QUERY_STRING
  char *QueryString = getenv("QUERY_STRING");
  // печатаем заголовок
  printf("Content-type: text/html\n\n");
  // печатаем документ
  printf("<html><body>");
  printf("<h1>Здравствуйте. Мы знаем о вас все!</h1>");
  printf("Ваш IP-адрес: %s<br>",RemoteAddr);
  printf("Вот параметры, которые Вы указали: %s",QueryString); 
  printf("</body></html>");
}
