<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>ユーザ登録ページ</title>
  <link type="text/css" rel="stylesheet" href="./css/common.css">
  <link type="text/css" rel="stylesheet" href="./css/thecloset.css">
</head>
<body class="login_body">
  <header>
    <div class="header-box">
      <h1><a class="logo" href="./login.php">THE CLOSET</a></h1>
    </div>
  </header>
  <div class="content">
    <div class="register">
<?php if(count($err_msg) > 0){ ?>
    <ul>
    <?php foreach($err_msg as $value){ ?>
        <li style="color:red; "><?php print $value; ?></li>
    <?php } ?>
    </ul>
<?php } ?>
<?php if(count($message) > 0){ ?>
    <ul>
    <?php foreach($message as $value){ ?>
        <li style="color:blue;"><?php print $value; ?></li>
    <?php } ?>
    </ul>
<?php } ?>
      <form method="post" action="./register.php">
        <div>ユーザー名：<input type="text" name="name" placeholder="ユーザー名"></div>
        <div>パスワード：<input type="password" name="passwd" placeholder="パスワード">
        <div><input type="submit" value="ユーザーを新規作成する">
      </form>
      <div class="login-link"><a href="./login.php">ログインページに移動する</a></div>
    </div>
  </div>
</body>
</html>