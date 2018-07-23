<?php
/*
*  ログイン処理
*
*  セッションの仕組み理解を優先しているため、一部処理はModelへ分離していません
*  また処理はセッション関連の最低限のみ行っており、本来必要な処理も省略しています
*/
require_once './include/conf/const.php';
require_once './include/model/model.php';
// リクエストメソッド確認
if (get_request_method() !== 'POST') {
   // POSTでなければログインページへリダイレクト
   header('Location: http://thecloset.jp/login.php');
   exit;
}
// セッション開始
session_start();
// POST値取得
$user_name  = get_post_data('user_name');  // ユーザー名
$passwd = get_post_data('passwd'); // パスワード
// メールアドレスをCookieへ保存
setcookie('user_name', $user_name, time() + 60 * 60 * 24 * 365);

login_check($user_name, $passwd);

?>