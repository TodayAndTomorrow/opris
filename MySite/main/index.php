<?
// Скрипт проверки
# Соединямся с БД
$db_host = 'localhost';
$db_port = '3307';
$db_username = 'mysql';
$db_password = 'mysql';
$db_name = 'users';
$db_charset = 'utf8';
$is_connected = @mysqli_connect($db_host,$db_username, $db_password, $db_name, $db_port);
$is_db_selected = $is_connected ? @mysqli_select_db($is_connected, $db_name) : FALSE;
if (!$is_connected)
    print 'Не могу соединиться с базой данных';
if (!$is_db_selected)
    print 'Не могу найти базу данных';
if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
    //$query = mysql_query("SELECT *,INET_NTOA(user_ip) FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
    //$userdata = mysql_fetch_assoc($query);
    $str = "SELECT *,INET_NTOA(staff_ip) FROM staff WHERE staff_id = '".intval($_COOKIE['id'])."' LIMIT 1";
    $query = mysqli_query($is_connected, $str);
    if ($query) {
        $data = mysqli_fetch_assoc($query);
    }else
        print "Че то не то";
    if(($data['staff_hash'] !== $_COOKIE['hash']) or ($data['staff_id'] !== $_COOKIE['id'])
        or (($data['staff_ip'] !== $_SERVER['REMOTE_ADDR'])  and ($data['staff_ip'] !== "0")))
    {
        setcookie("id", "", time() - 3600, "/");
        setcookie("hash", "", time() - 3600, "/");
		exit();
    }
    else
    {
        //print "Привет, ".$data['staff_login'].". Всё работает!";
        //exit();
    }
}
else
{
    //print(isset($_COOKIE['hash']));
    header("Location: /login");
}
?>
<!DOCTYPE HTML>
<html>

<head>
	<title>Q1</title>
	<meta charset="utf-8">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/data.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script type="text/javascript" src="js/jquery-1.4.min.js"></script>
	<script type="text/javascript" src="js/i18n/grid.locale-ru.js"></script>
	<script type="text/javascript" src="js/jquery.jqgrid.min.js"></script>
	
	<link rel="stylesheet" type="text/css" media="screen" href="css/flick/jquery-ui-1.7.2.custom.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="css/ui.jqgrid.css"/>
	<link href="style.css" rel="stylesheet" />
	
</head>

<body>
	<script src="code.js"></script>
	<nav id="navside">
	  <ul id="sidebar-menu">
		<li><a class="nav" id="a1" href="#">Продажи</a></li>
		<li><a class="nav" id="a2" href="#">План</a></li>
		<li><a class="nav" id="a3" href="#">Список товаров</a></li>
		<li><a id = "exit" href="">Выход</a></li>
	  </ul>
		<ul id="navmenu">

		</ul>
	
	</nav>
	<div id="toolbar">
		<input type = "button" class="button" id="btnP" value = "Сравнить план">
		
		</input>
		<input type = "button" class="button" id="btnSC" value = "Средний чек">
		
		</input>
		<input type = "button" class="button" id="btnD" value = "Выручка">
		
		</input>

	</div>
	<div id="content">
	
	</div>
</body>

</html>