<?php ## Макет описания управляющих структур языков PHP и JavaScript
$book="http://www.nevod.ru/nevod/staff/kaf/php5book";
$jsns="http://www.nevod.ru/nevod/staff/kaf/javascript";
$phpns="http://www.nevod.ru/nevod/staff/kaf/php5";
$controls=Array(
  'if'=>Array (
      'phpns'=>Array('format'=>'if (условие) блок else блок',
		     'descr' => '...'),
      'phpns'=>Array('format'=>'if (условие): блок else блок endif;',
		     'descr' => '...'),
       'jsns'=>Array('format'=>'if (условие) блок else блок',
		     'descr' => '...')
	  ),
  'for'=>Array(
      'phpns'=>Array('format'=>'for (установка; условие;выражение) блок',
		     'descr' => '...'),
       'jsns'=>Array('format'=>'for (установка; условие;выражение) блок',
		     'descr' => '...'),
       'jsns'=>Array('format'=>'for (переменная in объект) блок',
		     'descr' => '...')
      )
);
?>
