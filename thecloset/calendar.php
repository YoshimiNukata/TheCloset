<?php
require_once './include/conf/const.php';
require_once './include/model/model.php';

$err_msg = array();
$message = array();

$user_id   = login_user_id_check();

$user_name = get_user_name($user_id);

$link = get_db_connect();

$coodinate_date = get_get_data('date');

$coodinate_list = get_coodinate_list($link, $user_id, $coodinate_date);

$coodinate_list = convert_coodinate($coodinate_list);

close_db_connect($link);



include_once './include/view/calendar.php';
?>