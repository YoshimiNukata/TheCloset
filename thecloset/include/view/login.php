
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>ログインページ</title>
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
    <div class="message">
      <h2>洋服の管理をしませんか</h2>
    </div>
    <div class="login">
      <form method="post" action="./login_check.php">
        <div><input type="text" name="user_name" placeholder="ユーザー名"></div>
        <div><input type="password" name="passwd" placeholder="パスワード">
        <div><input type="submit" value="ログイン">
      </form>
<?php if($login_err_flag === true){ ?>
      <p>ユーザー名又はパスワードが違います</p>
<?php } ?>
      <div class="account-create">
        <a href="./register.php">ユーザーの新規作成</a>
      </div>
    </div>
  </div>
</body>
</html>
