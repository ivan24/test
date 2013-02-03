<?php
    $login ='fodo';
    $pass =  '2207qw';
    $url  = "http://google.ru";
    $name = 'Google';
    $tags = "teg for google";
    $description = 'this is descritption for google page';
    $next = "http://bobrdobr.ru/people/".$login;
    $killspammers = '';
    if($curl = curl_init()){
        // Нужно загрузить главную страницу бобра
        curl_setopt($curl,CURLOPT_URL,'http://bobrdobr.ru/');

        // Нужно помнить кукисы!
        curl_setopt($curl, CURLOPT_COOKIESESSION, TRUE);
        curl_setopt($curl, CURLOPT_COOKIEFILE, "cookiefile");

        // Скачанный код возвращаем в переменную а не в поток
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

        // "Следовать туда, куда зовут". Если сервис выдает 302 код, мы следуем по этой ссылке
        curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);

        // Таймаут, если сервис не отвечает больше 30 секунд, выходим
        curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,30);

        // Активируем GZIP сжатие трафика
        curl_setopt($curl,CURLOPT_ENCODING,'gzip,deflate');

        // Соврем Бобру, напишем в юзер-агент неправду
        curl_setopt($curl,CURLOPT_USERAGENT,'Bobr is fullish');
        // Если все ок, в $html вернется html код главной страницы
        if( $html = curl_exec($curl) ){

            // Указываем куда отправлять запрос
            curl_setopt($curl,CURLOPT_URL,'http://bobrdobr.ru/login/');

            // Указываем подключению, что слать нужно не GET (по умолчанию), а POST запросы
            curl_setopt($curl,CURLOPT_POST,TRUE);

            // Указываем, что именно отправлять в POST данных, на этой стадии происходит ввод логина/пароля
            curl_setopt($curl,CURLOPT_POSTFIELDS,"username=$login&password=$pass&remember_user=on&next=%2F");

            // Если все ок, в $html вернется html код главной страницы
            if( $html = curl_exec($curl) ){

                // Парсим этот сложнейший код, который защищает Доброго Бобра от спама!

                if( preg_match('/\<input type=\"hidden\" name=\"killspammers\" value=\"(.+?)\"\/\>/', $html, $out) ){
                var_dump($out);
                    // Отправляем СПАМ!

                    // Указываем куда отправлять запрос
                    curl_setopt($curl,CURLOPT_URL,'http://bobrdobr.ru/add/');

                    // Указываем, что именно отправлять в POST данных, на этой стадии происходит ввод логина/пароля
                    curl_setopt($curl,CURLOPT_POSTFIELDS,"killspammers=$out[1]&url=$url&name=$name&tags=$tags&description=$description&submit=%D0%A1%D0%BE%D1%85%D1%80%D0%B0%D0%BD%D0%B8%D1%82%D1%8C");

                    if( $html = curl_exec($curl) ){

                        echo 'Постинг выполнен!';
                    }else{
                        echo "error";
                    }
                }
            }
        }

        // Закрываем подключение, очищаем память
        curl_close($curl);

    }
?>