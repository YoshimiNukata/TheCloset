<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>購入完了ページ</title>
  <link type="text/css" rel="stylesheet" href="./css/common.css">
  <link type="text/css" rel="stylesheet" href="./css/thecloset.css">
</head>
<body>
  <header>
    <div class="header-box">
      <h1><a class="logo" href="./top.php">THE CLOSET</a></h1>
      <a class="nemu" href="./logout.php">ログアウト</a>
      <p class="nemu">ユーザー名：<?php print $user_name; ?></p>
    </div>
  </header>
  <div class="top_menu">
    <a href="./user_item.php">アイテム登録</a>
    <a href="./cart.php">今日のコーディネート</a>
    <a href="./calendar.php">コーディネート一覧表</a>
    <a href="./organize.php">断捨離のススめ</a>
  </div>
<main>
  <div class="content">
<?php if(count($err_msg) > 0){ ?>
    <ul>
    <?php foreach($err_msg as $value){ ?>
        <li><?php print $value; ?></li>
    <?php } ?>
    </ul>
<?php } ?>
<?php if(count($cart_list) > 0){ ?>
    <div class="finish-msg"><?php print $message[0]; ?></div>
    <div class="cart-list-title"></div>
    <ul class="cart-list">
  <?php foreach($cart_list as $cart){ ?>
      <li class="cart-item clearfix">
            <img class="cart-item-img" src="./item_img/<?php print $cart['img']; ?>">
            <span class="cart-item-name"><?php print $cart['name']?></span>
            <span class="cart_item_category"><?php print $cart['category_name']; ?></span>
      </li>
  <?php } ?>
    </ul>
<?php } ?>
  </div>
</main>
</body>
</html>
