<?php
require_once './include/conf/const.php';
require_once './include/model/model.php';

session_start();
// セッション変数からログイン済みか確認
if (isset($_SESSION['user_id']) === TRUE) {
   // ログイン済みの場合、ホームページへリダイレクト
   header('Location: http://thecloset.jp/top.php');
   exit;
}
// セッション変数からログインエラーフラグを確認
if (isset($_SESSION['login_err_flag']) === TRUE) {
   // ログインエラーフラグ取得
   $login_err_flag = $_SESSION['login_err_flag'];
   // エラー表示は1度だけのため、フラグをFALSEへ変更
   $_SESSION['login_err_flag'] = FALSE;
} else {
   // セッション変数が存在しなければエラーフラグはFALSE
   $login_err_flag = FALSE;
}
// Cookie情報からメールアドレスを取得
if (isset($_COOKIE['user_name']) === TRUE) {
   $user_name = $_COOKIE['user_name'];
} else {
   $user_name = '';
}
// 特殊文字をHTMLエンティティに変換
$user_name = entity_str($user_name);

include_once './include/view/login.php';