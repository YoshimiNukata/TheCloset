<?php
require_once './include/conf/const.php';
require_once './include/model/model.php';

$err_msg = array();
$message = array();

$user_id   = login_user_id_check();

$user_name = get_user_name($user_id);

$link = get_db_connect();

$organize_list = get_organize_list($link, $user_id, $coodinate_date);

close_db_connect($link);

include_once './include/view/organize.php';
?>