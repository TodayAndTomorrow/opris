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
$str = "SELECT sale_id as 'Номер продажи',sale_date as 'Дата продажи',employee_FirstName as 'Имя продавца', employee_LastName as 'Фамилия продавца', item_name as 'Что продал', sale_count as 'Количество',"."
	item_price*sale_count as 'На сумму' FROM shop.sale, shop.item, shop.employee where sale.sale_id_item = item.item_id and sale.sale_id_employee = employee.employee_id;";
$query = mysqli_query($is_connected, $str);
//echo $query;
if ($query) {
    while($raw = mysqli_fetch_object($query) )
        $data[] = $raw;
}
mysqli_close($is_connected);
header('Content-type: application/json');
echo json_encode($data);