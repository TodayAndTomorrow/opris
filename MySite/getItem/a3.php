<?php
/**
 * Created by PhpStorm.
 * User: rama
 * Date: 04.12.2015
 * Time: 2:58
 */
$db_host = 'localhost';
$db_port = '3307';
$db_username = 'mysql';
$db_password = 'mysql';
$db_name = 'users';
$db_charset = 'utf8';
$is_connected = @mysqli_connect($db_host, $db_username, $db_password, $db_name, $db_port);
$is_db_selected = $is_connected ? @mysqli_select_db($is_connected, $db_name) : FALSE;
if (!$is_connected)
    print 'Не могу соединиться с базой данных';
if (!$is_db_selected)
    print 'Не могу найти базу данных';
$str = "SELECT item_id as 'Номер товара', item_name as 'Название', item_desc as 'Описание', item_price as 'Цена за единицу' FROM shop.item";
$query = mysqli_query($is_connected, $str);
//echo $query;
if ($query) {
    while($raw = mysqli_fetch_object($query) )
    $data[] = $raw;
}
mysqli_close($is_connected);
header('Content-type: application/json');
echo json_encode($data);