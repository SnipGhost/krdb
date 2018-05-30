<?php

	if (isset($_GET['code'])) {
		$id = $_GET['code'];
	} else {
		$id = 404;
	}

	$a[401] = "Требуется авторизация";
	$a[403] = "Доступ запрещен";
	$a[404] = "Файл не найден";
	$a[500] = "Внутренняя ошибка сервера";
	$a[400] = "Неправильный запрос";

?>
<html>
 <head>
  <title>Ошибка</title>	
  <meta http-equiv="Content-Language" content="ru">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<style>
		* {
			margin: 0;
			padding: 0;
		}
		body {
			align: center;
			padding: 200px 50px 50px 50px;
			xxx-background: #00a;
			background: #2f4e81;
			color: white;
			font-family: Courier New;
		}
		body a {
			color: white;
		}
	</style>
	<script type="text/javascript">
		function handler(event) {
			switch(event.keyCode) {
				default:
					history.back();
				}	
		}
		window.addEventListener('keydown', handler, false);
	</script>
 </head>	
 <body>
	<center>
 	<h1>Kernel panic!</h1>
 	<br><br>
 	Произошла ошибка. Для продолжения: <br>
 	Нажмите любую клавишу, чтобы вернуться назад, или тыкните <a href="javascript:history.back();">ЗДЕСЬ</a> <br>
 	<br><br>
 	Зажмите CTRL+ALT+DEL и перезагрузите ваш компьютер, но это точно не поможет. <br>
 	<br><br>
 	<b>Код ошибки: <?=$id?></b><br>
	<b>Расшифровка: <?=$a[$id]?></b><br>
	<br><br>
 	<b>Press ANY key to continue</b>
	</center>
 </body>
</html>