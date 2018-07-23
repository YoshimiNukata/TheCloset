<?php
/*
*  ログイン済みユーザのホームページ
*
*  セッションの仕組み理解を優先しているため、一部処理はModelへ分離していません
*  また処理はセッション関連の最低限のみ行っており、本来必要な処理も省略しています
*/
require_once './include/conf/const.php';
require_once './include/model/model.php';

$err_msg = array();
$message = array();
$category_name = 'ALL';

//12と14は会員ページの為、絶対必要
$user_id   = login_user_id_check();

$user_name = get_user_name($user_id);

$link      = get_db_connect();

//postがある場合の処理(カート処理)
if(get_request_method() === 'POST'){
    //値の取得
    $sql_kind = get_post_data('sql_kind');
    
    if($sql_kind === 'insert_coordinate'){
        //処理の内容
        $item_id = get_post_data('item_id');
        
        //エラーチェック
        check_item_id($item_id);
        
        if(count($err_msg) === 0){
            //カートにデータがあるかどうか
            $coordinate_data = get_coordinate_data($link, $user_id, $item_id);
            
            if(count($coordinate_data) > 0){
                
                //カート情報の更新
                update_coordinate($link, $user_id, $item_id);
                
                
            }else{
                //insert処理
                insert_coordinate($link, $user_id, $item_id);
            }
        }
    }
}

$category_id = get_get_data('category_id');

$category_name = get_category_name($link, $category_id);


$item_list = get_user_item_list($link, $user_id, $category_id);

$item_list = entity_assoc_array($item_list);


close_db_connect($link);


// ログイン済みユーザのホームページ表示
include_once './include/view/top.php';
?>