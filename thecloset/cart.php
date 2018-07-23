<?php
require_once './include/conf/const.php';
require_once './include/model/model.php';

$err_msg = array();
$message = array();

$user_id   = login_user_id_check();

$user_name = get_user_name($user_id);

$link      = get_db_connect();

if(get_request_method() === 'POST'){
    $sql_kind = get_post_data('sql_kind');    
    if($sql_kind === 'delete_cart'){
        //削除処理
        $item_id = get_post_data('item_id');
        
        //エラーチェック
        check_item_id($item_id);
        
        if(count($err_msg) === 0){
            delete_cart($link, $user_id, $item_id);
        }
    }
}

//常に表示する処理
//カートの一覧
$cart_list = get_cart_list($link, $user_id);

//エラーチェック
if(count($cart_list) === 0){
    $err_msg[] = '商品はありません';
}

//合計金額の表示
$total_price = get_total_price($cart_list);

close_db_connect($link);

$cart_list = entity_assoc_array($cart_list);

include_once './include/view/cart.php';
?>