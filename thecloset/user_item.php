<?php
require_once './include/conf/const.php';
require_once './include/model/model.php';

$err_msg = array();
$message = array();

$user_id   = login_user_id_check();
$user_name = get_user_name($user_id);

//管理用ユーザー限定処理(admin,admin)
session_start();
// セッション変数からログイン済みか確認
if (isset($_SESSION['user_id']) !== TRUE) {
   // ログイン済みの場合、ホームページへリダイレクト
   header('Location: http://thecloset.jp//php/login.php');
   exit;
}


$link      = get_db_connect();

if(get_request_method() === 'POST'){
    
    $sql_kind = get_post_data('sql_kind');
    
    if($sql_kind === 'category'){
        
        //値の取得
        $item_id = get_post_data('item_id');
        $change_category = get_post_data('change_category');
        
        //エラーチェック
        check_item_id($item_id);
        check_change_category($change_category);
        
        if(count($err_msg) === 0){
            //update処理
            update_category($link, $item_id, $change_category);
        }
    }
    
    if($sql_kind === 'delete'){
        
        //値の取得
        $item_id = get_post_data('item_id');
        
        //エラーチェック
        check_item_id($item_id);
        
        if(count($err_msg) === 0){
            //delete処理
            delete_item($link, $item_id);
        }
    }
    
    if($sql_kind === 'insert'){
        
        //値の取得
        $new_name   = get_post_data('new_name');
        $new_category = get_post_data('new_category');
        
        //エラーチェック
        check_new_name($new_name);
        check_change_category($new_category);
        
        if(count($err_msg) === 0){
            //imgの処理
            if(isset($_FILES) && isset($_FILES['new_img']) && is_uploaded_file($_FILES['new_img']['tmp_name'])){
                //値の取得
                $img_name = $_FILES['new_img']['name'];
                $tmp_name = $_FILES['new_img']['tmp_name']; //サーバーのデータ
                
                //エラーチェック
                check_img_name($img_name);
                
                //MIMEタイプのチェック
                //画像ファイルデータを取得
                $img_data = file_get_contents($tmp_name);
                //MIMEタイプの取得
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_buffer($finfo, $img_data);
                finfo_close($finfo);
                //MIMEタイプの出力
                
                //拡張子の配列（拡張子の種類を増やせば、画像以外のファイルでもOKです）
                $extension_array = array(
                    'gif' => 'image/gif',
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png'
                );
                //MIMEタイプから拡張子を出力
                $img_extension = array_search($mime_type, $extension_array,true);
                    //拡張子の出力
//echo $img_extension;
                
                if(preg_match('/^jpg|png$/', $img_extension) !== 1){
                    $err_msg[] = 'ファイル形式はJPEGまたはPNGを入力してください';
                }
                 
                if(count($err_msg) === 0){
                    if(move_uploaded_file($tmp_name, 'item_img/' . $img_name)){
                        $msg = $img_name. 'のアップロードに成功しました';
                    }else {
                        $err_msg[] = 'アップロードに失敗しました';
                    }
                }
            }
        }
        
        if(count($err_msg) === 0){
            
            insert_item_data($link, $new_name, $user_id, $img_name, $new_category);
                                    
            if(count($err_msg) === 0){
                
                $messaƒge[] = '新規商品の追加が完了しました';
                
            }else{
                $err_msg[] = '商品の追加に失敗しました';
            }
            
        }
    }
    
}

//常に表示する処理
$item_list = get_item_list($link, $user_id);

close_db_connect($link);

$item_list = entity_assoc_array($item_list);

include_once './include/view/user_item.php';
?>