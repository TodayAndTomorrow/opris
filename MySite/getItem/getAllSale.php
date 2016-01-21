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
//$str = "SELECT planSale_id as 'Номер плана', plan_date_begin as 'Начало',plan_date_end as 'Конец', plan_current_result as 'Текущий результат',
//	 plan_theplan as 'План' FROM shop.plansale;";
$str = "USE shop; SELECT YEAR(sale_date) as 'Sale_timeYear', MONTHNAME(sale_date) as 'Sale_time', sum(sale_count*item_price) as 'How much money' FROM item,sale WHERE item_id=sale_id_item group by MONTH(sale_date);";
$query = mysqli_query($is_connected, $str);
//echo $query;
if ($query) {
    while($raw = mysqli_fetch_object($query) )
        $data[] = $raw;
}
mysqli_close($is_connected);
header('Content-type: application/json');
echo json_encode($data);
