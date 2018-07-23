<?php
require_once './include/conf/const.php';
require_once './include/model/model.php';

$err_msg = array();
$message = array();

$user_id   = login_user_id_check();

$user_name = get_user_name($user_id);

$link = get_db_connect();

//POSTが送られてき場合
if(get_request_method()  === 'POST'){
    
    //購入商品(カート内の商品)の表示
    $cart_list = get_cart_list($link, $user_id);
    //$item_list = get_item_list($link, $user_id);
    
    
    
    
    if(count($cart_list) > 0){

        $coodinate_id = get_max_coodinate_id($link, $user_id);
        
        mysqli_autocommit($link, false);

        foreach($cart_list as $cart){
            
            $item_id = $cart['item_id'];

            insert_history_table($link, $user_id, $item_id, $coodinate_id);
            
        }

        delete_coodinate_user($link, $user_id);


        if(count($err_msg) === 0){
            mysqli_commit($link);
            $message[] = 'コーディネートの履歴を追加しました';
        }else{
            mysqli_rollback($link);
        }

    }else{
        $err_msg[] = 'コーディネートの履歴がありません';
    }
    
    if(count($message) === 0){
        $message[] = 'もう一度やり直してください';
    }
    
    close_db_connect($link);
    
    $cart_list = entity_assoc_array($cart_list);
}else{
    $cart_list = array();
    $err_msg[] = '不正な処理です';
}



include_once './include/view/finish.php';
?>