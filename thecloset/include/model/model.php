<?php
/**
* 特殊文字をHTMLエンティティに変換する
* @param str  $str 変換前文字
* @return str 変換後文字
*/
function entity_str($str) {
    return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}
 
/**
* 特殊文字をHTMLエンティティに変換する(2次元配列の値)
* @param array  $assoc_array 変換前配列
* @return array 変換後配列
*/
function entity_assoc_array($assoc_array) {
 
    foreach ($assoc_array as $key => $value) {
 
        foreach ($value as $keys => $values) {
            // 特殊文字をHTMLエンティティに変換
            $assoc_array[$key][$keys] = entity_str($values);
        }
 
    }
 
    return $assoc_array;
 
}

/**
* DBハンドルを取得
* @return obj $link DBハンドル
*/
function get_db_connect() {
 
    // コネクション取得
    if (!$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME)) {
        die('error: ' . mysqli_connect_error());
    }
 
    // 文字コードセット
    mysqli_set_charset($link, DB_CHARACTER_SET);
 
    return $link;
}
 
/**
* DBとのコネクション切断
* @param obj $link DBハンドル
*/
function close_db_connect($link) {
    // 接続を閉じる
    mysqli_close($link);
}
 
/**
* クエリを実行しその結果を配列で取得する
*
* @param obj  $link DBハンドル
* @param str  $sql SQL文
* @return array 結果配列データ
*/
function get_as_array($link, $sql) {
 
    // 返却用配列
    $data = array();
 
    // クエリを実行する
    if ($result = mysqli_query($link, $sql)) {
 
        if (mysqli_num_rows($result) > 0) {
 
            // １件ずつ取り出す
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
 
        }
 
        // 結果セットを開放
        mysqli_free_result($result);
 
    }
 
    return $data;
 
}
 
/**
* 商品の一覧を取得する
*
* @param obj $link DBハンドル
* @return array 商品一覧配列データ
*/
function get_user_item_list($link, $user_id, $category_id){
    
    //sql生成
    $sql = 'SELECT item_table.item_id, name, user_id, category_id, img
            FROM item_table
            WHERE user_id = ' . $user_id;

    if(mb_strlen($category_id) > 0){
        $sql .= ' AND category_id = ' . $category_id;
    }
    
    //クエリ実行
    return get_as_array($link, $sql);
}



function get_item_list($link, $user_id){
    
    //sql生成
    $sql = 'SELECT item_table.item_id, name, user_id, category_id, img
            FROM item_table
            WHERE user_id = ' . $user_id;
    
    //クエリ実行
    return get_as_array($link, $sql);
}


function get_cart_list($link, $user_id){
    //クエリ生成
    $sql = 'SELECT item_table.item_id, name, item_table.user_id, img, category_table.category_name, coordinate_table.amount
            FROM item_table
            JOIN coordinate_table
            ON   item_table.item_id = coordinate_table.item_id
            JOIN category_table
            ON item_table.category_id = category_table.category_id
            WHERE item_table.user_id = ' . $user_id . '
            AND amount > 0';

    
    //クエリ実行
    return get_as_array($link, $sql);
}

function get_coordinate_data($link, $user_id, $item_id){
    
    //sql生成
    $sql = 'SELECT cart_id 
            FROM coordinate_table
            WHERE user_id = ' . $user_id . '
            AND item_id = ' . $item_id;
    
    //クエリ実行
    return get_as_array($link, $sql);
    
}

function get_coodinate_list($link, $user_id, $coodinate_date){
    $coodinate_date = str_replace('/', '-', $coodinate_date);
    $where_txt = ' WHERE history_table.user_id = ' . $user_id;

    if(mb_strlen($coodinate_date) > 0){
        $where_txt .= ' AND LEFT(history_table.created_date, 10) = \'' . $coodinate_date . '\'' ;
    }
    //sql
    $sql = 'SELECT coodinate_id, history_table.user_id, history_table.item_id, history_table.created_date, name, img, item_table.category_id, category_name 
            FROM history_table 
            JOIN item_table 
            ON history_table.item_id = item_table.item_id 
            JOIN category_table 
            ON item_table.category_id = category_table.category_id 
            ' . $where_txt . ' 
            ORDER BY history_table.user_id, history_table.created_date desc, coodinate_id, history_id';
// print $sql;

    return get_as_array($link, $sql);
}

function get_organize_list($link){

    
    $sql = 'SELECT  t.item_id,item_table.img,item_table.name,category_table.category_name,datediff(CURRENT_DATE(),t.created_date) as diff 
            FROM (SELECT item_id, MAX(history_table.created_date) as created_date 
            FROM history_table GROUP BY item_id) as t
            JOIN item_table
            ON t.item_id = item_table.item_id
            JOIN category_table
            ON item_table.category_id = category_table.category_id
            WHERE datediff(CURRENT_DATE(),t.created_date) >= 365
            UNION
            SELECT  item_table.item_id,item_table.img,item_table.name,category_table.category_name,datediff(CURRENT_DATE(),item_table.created_date) as diff 
            FROM item_table
            JOIN category_table
            ON item_table.category_id = category_table.category_id
            WHERE datediff(CURRENT_DATE(),item_table.created_date) >= 365
            AND NOT EXISTS(SELECT * FROM history_table WHERE item_id = item_table.item_id)
            ORDER BY 2 DESC';

    return get_as_array($link, $sql);
}




function get_user_data($link, $name){
    
    //sql生成
    $sql = 'SELECT user_name
            FROM user_table
            WHERE user_name = \'' . $name . '\'';

    //クエリ実行
    return get_as_array($link, $sql);
}

function get_user_list($link){
    
    //sql生成
    $sql = 'SELECT user_name, created_date
            FROM user_table';
    
    return get_as_array($link, $sql);
}

function get_category_name($link, $category_id){
    $category_name = 'ALL';
    $sql = 'SELECT category_name
            FROM category_table
            WHERE category_id = ' . $category_id;
    
    $data =  get_as_array($link, $sql);

    if(count($data) > 0){
        $category_name = $data[0]['category_name'];
    }
    return $category_name;
}

function get_max_coodinate_id($link, $user_id){

    $max_id = 0;

    $sql = 'SELECT MAX(coodinate_id) as max_id
            FROM history_table
            WHERE user_id = ' . $user_id;
    
    $data =  get_as_array($link, $sql);

    if(count($data) > 0){
        $max_id = $data[0]['max_id'];
    }

    return $max_id + 1;

}

/**
* insertを実行する
*
* @param obj $link DBハンドル
* @param str SQL文
* @return bool
*/
function insert_db($link, $sql) {
   // クエリを実行する
   if (mysqli_query($link, $sql) === TRUE) {
       return TRUE;
   } else {
       return FALSE;
   }
}
/**
* 新規商品を追加する
*
* @param obj $link DBハンドル
* @param str $goods_name 商品名
* @param int $price 価格
* @return bool
*/
function insert_goods_table($link, $goods_name, $user_id) {
   // SQL生成
   $sql = 'INSERT INTO goods_table(goods_name, user_id) 
           VALUES(\'' . $goods_name . '\', ' . $user_id . ')';
   // クエリ実行
   return insert_db($link, $sql);
}

function insert_coordinate($link, $user_id, $item_id){
    global $err_msg, $message;
    
    $date = date('Y-m-d H:i:s');
    
    $data = array(
        'user_id' => $user_id,
        'item_id'  => $item_id,
        'amount' => 1,
        'created_date' => $date,
        'updated_date' => $date
    );
    
    $sql = 'INSERT INTO `coordinate_table`(`user_id`, `item_id`, `amount`, `created_date`, `updated_date`) 
            VALUES(\'' . implode('\',\'', $data) . '\')';
            
    if(insert_db($link, $sql) !== true){
        $err_msg[] = 'コーディネートにアイテムを追加できません';
    }else{
        $message[] = 'コーディネートにアイテムを追加しました';
    }
}

function insert_user_data($link, $name, $passwd){
    global $err_msg, $message;
    
    $date = date('Y-m-d H:i:s');
    
    $data = array(
        'user_name' => $name,
        'password' => $passwd,
        'created_date' => $date,
        'updated_date' => $date
    );
    //sql生成
    $sql = 'INSERT INTO `user_table`(`user_name`, `password`, `created_date`, `updated_date`) 
            VALUES (\'' . implode('\',\'', $data) . '\')';
// print $sql;
// exit;
            
    //クエリ実行
    if(insert_db($link, $sql) !== true){
        $err_msg[] = 'ユーザー登録に失敗しました';
    }else{
        $message[] = 'ユーザー登録に成功しました';
    }
}

function insert_item_data($link, $new_name, $user_id, $img_name, $new_category){
    global $err_msg, $message;
    
    $date = date('Y-m-d H:i:s');
    $data = array(
        'name' => $new_name,
        'user_id'      => (int)$user_id,
        'img'        => $img_name ,
        'category_id'    => (int)$new_category,
        'created_date'    => $date,
        'updated_date'    => $date,
    );
    
    $sql = 'INSERT INTO item_table(name, user_id, img, category_id, created_date, updated_date)
            VALUES (\'' . implode('\', \'', $data) . '\')';
    
    //クエリ実行
    if(insert_db($link, $sql) !== true){
        
        $err_msg[] = 'アイテム登録に失敗しました';
        
        
    }else{
        
        $message[] = 'アイテム登録に成功しました';
        
    }
}

function insert_history_table($link, $user_id, $item_id, $coodinate_id){
    $date = date('Y-m-d H:i:s');

    $data = array(
        'coodinate_id' => $coodinate_id,
        'user_id'      => $user_id,
        'item_id'      => $item_id,
        'created_date' => $date,
        'updated_date' => $date
    );

    $sql = 'INSERT INTO `history_table`(`coodinate_id`, `user_id`, `item_id`, `created_date`, `updated_date`) 
            VALUES (\'' . implode('\', \'', $data) . '\')';

    if(insert_db($link, $sql) !== true){
        $err_msg[] = '履歴の追加に失敗しました(' . $item_id . ')';
    }
}


function update_category($link, $item_id, $change_category){
    global $err_msg, $message;
    
    $date = date('Y-m-d H:i:s');
    
    $sql = 'UPDATE item_table
            SET category_id = ' . (int)$change_category . ',
            updated_date = \'' . $date . '\'
            WHERE item_id = ' . $item_id;

    
    if(insert_db($link, $sql) !== true){
        $err_msg[] = 'カテゴリーの変更を失敗しました';
    }else{
        $message[] = 'カテゴリーを変更しました';
    }
}





function update_coordinate($link, $user_id, $item_id){
    global $err_msg, $message;
    
    $date = date('Y-m-d H:i:s');
    
    $sql = 'UPDATE `coordinate_table` 
            SET `amount`= amount + 1,
                `updated_date`= \'' . $date . '\' 
            WHERE user_id = ' . $user_id . '
            AND item_id = ' . $item_id;

    if(insert_db($link, $sql) !== true){
        $err_msg[] = 'コーディネートが更新できません';
    }else{
        $message[] = 'コーディネートを更新しました';
    }
}


function delete_cart($link, $user_id, $item_id){
    global $err_msg, $message;
    
    $sql = 'DELETE 
            FROM `coordinate_table` 
            WHERE user_id = ' . $user_id . '
            AND item_id = ' . $item_id;
    
    if(insert_db($link, $sql) !== true){
        $err_msg[] = 'アイテムの削除に失敗しました';
    }else{
        $message[] = 'アイテムを削除しました';
    }
    
}

function delete_coodinate_user($link, $user_id){
    global $err_msg, $message;
    
    $sql = 'DELETE 
            FROM `coordinate_table` 
            WHERE user_id = ' . $user_id;
            
    if(insert_db($link, $sql) !== true){
        $err_msg[] = 'アイテムの削除に失敗しました';
    }
}

function delete_item($link, $item_id){
    global $err_msg, $message;
    
    $sql = 'DELETE 
            FROM `item_table` 
            WHERE item_id = ' . $item_id;
            
    if(insert_db($link, $sql) !== true){
        $err_msg[] = 'アイテムの削除に失敗しました';
    }else{
        $message[] = 'アイテムを削除しました';
    }
}


/**
* リクエストメソッドを取得
* @return str GET/POST/PUTなど
*/
function get_request_method() {
   return $_SERVER['REQUEST_METHOD'];
}
/**
* POSTデータを取得
* @param str $key 配列キー
* @return str POST値
*/
function get_post_data($key) {
   $str = '';
   if (isset($_POST[$key]) === TRUE) {
       $str = trim(mb_convert_kana($_POST[$key], 's'));
   }
   return $str;
}

function get_get_data($key){
    $str = '';
    if(isset($_GET[$key]) === TRUE){
        $str = trim(mb_convert_kana($_GET[$key], 's'));
    }
    return $str;
}


function login_user_id_check(){
    // セッション開始
    session_start();
    // セッション変数からuser_id取得 isset($_SESSION['user_id'])はログインが正しい
    if (isset($_SESSION['user_id']) === TRUE) {
       $user_id = $_SESSION['user_id'];
    } else {
       // 非ログインの場合、ログインページへリダイレクト
       header('Location: http://thecloset.jp/login.php');
       exit;
    }
    //user_idは他でも使う為
    return $user_id;
}

function login_check($user_name, $passwd){
    // データベース接続
    $link = get_db_connect();
    // メールアドレスとパスワードからuser_idを取得するSQL
    $sql = 'SELECT user_id
            FROM user_table
            WHERE user_name = \'' . $user_name . '\' 
            AND password  = \'' . $passwd . '\'';
    // SQL実行し登録データを配列で取得
    $data = get_as_array($link, $sql);
    // データベース切断
    close_db_connect($link);
    
    // 登録データを取得できたか確認
    if (isset($data[0]['user_id'])) {
       // セッション変数にuser_idを保存
       $_SESSION['user_id'] = $data[0]['user_id'];
       if($user_name === 'admin'){
            header('Location: http://thecloset.jp/admin.php');
       }else{
            header('Location: http://thecloset.jp/top.php');
       }
       exit;
    } else {
       // セッション変数にログインのエラーフラグを保存
       $_SESSION['login_err_flag'] = TRUE;
       // ログインページへリダイレクト
       header('Location: http://thecloset.jp/login.php');
       exit;
    }
}

function get_user_name($user_id){
    //ログインができたらuser_nameを取得する
    // データベース接続
    $link = get_db_connect();
    // user_idからユーザ名を取得するSQL
    $sql = 'SELECT user_name 
            FROM user_table 
            WHERE user_id = ' . $user_id;
    // SQL実行し登録データを配列で取得
    $data = get_as_array($link, $sql);
    // データベース切断
    close_db_connect($link);
    // ユーザ名を取得できたか確認
    if (isset($data[0]['user_name'])) {
       $user_name = $data[0]['user_name'];
    } else {
       // ユーザ名が取得できない場合、ログアウト処理へリダイレクト
       header('Location: http://thecloset.jp/logout.php');
       exit;
    }
    return $user_name;
}

function check_item_id($item_id){
    global $err_msg;
    if($item_id === ''){
        $err_msg[] = '商品が選択されていません';
    }else if(preg_match('/^[0-9]+$/', $item_id) !== 1){
        $err_msg[] = '正しい商品を選択してください';
    }
}

function check_new_name($new_name){
    global $err_msg;
    if($new_name === ''){
        $err_msg[] = '名前を入力してください';
    }
}

function check_img_name($img_name){
    global $err_msg;
    if(preg_match('/\.(jpeg|jpg|png)$/', $img_name) !== 1){
        $err_msg[] = 'ファイル名が正しくありません';
    }
}

function check_name($name){
   global $err_msg; 
   if($name === ''){
       $err_msg[] = 'ユーザー名が入力されていません';
   }else if(preg_match('/^[a-zA-Z0-9]{6,}$/', $name) !== 1){
       $err_msg[] = 'ユーザー名は6文字以上の英数字を入力してください';
   }
}

function check_email($email){
    global $err_msg;
    if($email === ''){
        $err_msg[] = 'メールアドレスが入力されていません';
    }else if(preg_match('/^[a-zA-Z0-9_\.]+@([a-z0-9]+\.+)+[a-z0-9]+$/', $email) !== 1){
        $err_msg[] = '正しいメールアドレスを入力してください';
    }
}

function check_passwd($passwd){
    global $err_msg;
    if($passwd === ''){
        $err_msg[] = 'パスワードを入力してください';
    }else if(preg_match('/^[a-zA-Z0-9]{6,}$/', $passwd) !== 1){
        $err_msg[] = 'パスワードは6文字以上の英数字を入力してください';
    }
}

function check_change_category($new_category){
    global $err_msg;
    if($new_category === ''){
        $err_msg[] = 'カテゴリーを入力してください';
    }else if(preg_match('/^[1-9]$/', $new_category) !== 1){
        $err_msg[] = '正しいカテゴリーを入力してください';
    }
     

}


function check_up_file(){
    global $err_msg, $tmp_name, $img_name;
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

        if($_FILES['new_img']['size'] > 10000000){
            $err_msg[] = 'ファイルサイズは10MB以下にしてください';
            
        }
        
    }else{
        $err_msg[] = '画像ファイルがありません';
    }
}

function move_up_file(){
    global $err_msg, $msg, $tmp_name, $img_name;
    if(move_uploaded_file($tmp_name, 'item_img/' . $img_name)){
        $msg = $img_name. 'のアップロードに成功しました';
    }else {
        $err_msg[] = 'アップロードに失敗しました';
    }
}

function get_total_price($cart_list){
    
    //cart_listは2次元配列(金額などのデータも入っている)
    $total_price = 0;
    foreach($cart_list as $cart){
        $total_price += $cart['price'] * $cart['amount'];
    }
    
    return $total_price;
}

function convert_coodinate($coodinate_list){

    $data = array();
    foreach($coodinate_list as $value){
        $date     = $value['created_date'];
        $now_date = date('Y年n月j日', strtotime($date));
        $coodinate_id = $value['coodinate_id'];
        $item_id = $value['item_id'];
        $data[$now_date][$coodinate_id][$item_id]['item_id']       = $value['item_id'];
        $data[$now_date][$coodinate_id][$item_id]['img']           = $value['img'];
        $data[$now_date][$coodinate_id][$item_id]['name']          = $value['name'];
        $data[$now_date][$coodinate_id][$item_id]['category_name'] = $value['category_name'];

    }


    return $data;
}

