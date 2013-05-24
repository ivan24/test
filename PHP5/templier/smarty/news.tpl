{* Шаблон новостей. *}
<html>
<head><title>Последние новости</title></head>
<body>
<h1>Последние новости</h1>
<ul>
{foreach from="$news" item="n"}
  <li><b>{$n.date}</b> {$n.text}
{/foreach}
</body>
</html>
