<?php
/**
 * Created by PhpStorm.
 * User: rama
 * Date: 05.11.2015
 * Time: 21:43
 * Page: autho
 */
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
//print isset($_COOKIE['id']);
//print isset($_COOKIE['hash']);
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
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/");
        //print $data['staff_hash'];
        //print $_COOKIE['hash'];
        //print $data['staff_id'];
        //print $_COOKIE['id'];
    }
    else
    {
        header("Location: /main");
        //print "Привет, ".$data['staff_login'].". Всё работает!";
    }
}else
{
    # Функция для генерации случайной строки
    function generateCode($length = 6)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0, $clen)];
        }
        return $code;
    }
    //$is_connected = @mysqli_connect($db_host, $db_username, $db_password, $db_name, $db_port);
    //$is_db_selected = $is_connected ? @mysqli_select_db($is_connected, $db_name) : FALSE;
    if (!$is_connected)
        print 'Не могу соединиться с базой данных';
    if (!$is_db_selected)
        print 'Не могу найти базу данных';
    if (isset($_POST['submit']) AND $is_connected AND $is_db_selected) {
        # Вытаскиваем из БД запись, у которой логин равняеться введенному
        $strEcran = mysqli_real_escape_string($is_connected, $_POST['login']);
        $str = "SELECT staff_id, staff_password FROM staff WHERE staff_login ='" . $strEcran . "' LIMIT 1";
        $query = mysqli_query($is_connected, $str);
        //echo $query;
        if ($query) {
            $data = mysqli_fetch_assoc($query);
        } else
            print "Че то не то";
        # Сравниваем пароли
        if ($data['staff_password'] === md5(md5($_POST['password']))) {
			$hash = md5(generateCode(10));
            # Записываем в БД новый хеш авторизации и IP
            mysqli_query($is_connected, "UPDATE staff SET staff_hash='" . $hash . "' WHERE staff_id=" . $data['staff_id'] . "");
            # Ставим куки
            setcookie("id", $data['staff_id'], time() + 3600, "/");
            setcookie("hash", $hash, time() + 3600, "/");
            # Переадресовываем браузер на страницу проверки нашего скрипта
            $is_connected = mysqli_close($is_connected);
            if (!$is_connected) {
                echo "БД не закрылась";
                print "Вы ввели правильный логин/пароль";
                exit();
            }
            header("Location: /main");
            exit();
        } else {
            $is_connected = mysqli_close($is_connected);
            //print "Вы ввели неправильный логин/пароль";
            Header("Location: /login");
        }
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Окно Входа</title>
    <meta charset="UTF-8" />
    <link href="style.css" rel="stylesheet" />
</head>

<body>
<form id="loginForm" action="/login/" method="post">
    <div class="field">
        <label>Логин:</label>
        <div class="input">
            <input type="text" name="login" value="" id="login" />
        </div>
    </div>
    <div class="field">
        <label>Пароль:</label>
        <div class="input">
            <input type="password" name="password" value="" id="pass" />
        </div>
    </div>
    <div class="submit">
        <button name="submit" type="submit">Войти</button>
    </div>
</form>
</body>
</html>

