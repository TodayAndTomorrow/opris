<?

// Скрипт проверки
# Соединямся с БД
$db_host = 'localhost';
$db_port = '3306';
$db_username = 'root';
$db_password = '123456789';
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
        print "Привет, ".$data['staff_login'].". Всё работает!";
    }
}

else
{
    print "Включите куки";
}
?>
