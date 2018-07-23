<?php

require_once './include/conf/const.php';
require_once './include/model/model.php';

$err_msg = array();
$message = array();

$link  = get_db_connect();

if(get_request_method() === 'POST'){
    //値の取得
    $name = get_post_data('name');
    $passwd = get_post_data('passwd');
    
    //エラーチェック
    check_name($name);
    check_passwd($passwd);
    
    if(count($err_msg) === 0){
        //ユーザーデータがあるかどうか
        $user_data = get_user_data($link, $name);

        if(count($user_data) > 0){
            $err_msg[] = '同じユーザー名が既に登録されています';
        }else{
            insert_user_data($link, $name, $passwd);
        }
    }
    
    
}

include_once './include/view/register.php';