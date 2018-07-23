
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>今日のコーディネート</title>
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
    <a href="./cart.php" class="selected">今日のコーディネート</a>
    <a href="./calendar.php">コーディネート一覧表</a>
    <a href="./organize.php">断捨離のススめ</a>
  </div>
  <main>
    <div class="content">
      <h1 class="title">今日のコーディネート</h1>
  <?php if(count($err_msg) > 0){ ?>
      <ul>
      <?php foreach($err_msg as $value){ ?>
          <li><?php print $value; ?></li>
      <?php } ?>
      </ul>
  <?php } ?>
  <?php if(count($message) > 0){ ?>
      <ul>
      <?php foreach($message as $value){ ?>
          <li><?php print $value; ?></li>
      <?php } ?>
      </ul>
  <?php } ?>
      <div class="cart-list-title"></div>
      <ul class="cart-list">
  <?php foreach($cart_list as $cart){ ?>
        <li class="cart-item clearfix">
            <img class="cart-item-img" src="./item_img/<?php print $cart['img']; ?>">
            <span class="cart-item-name"><?php print $cart['name']?></span>
            <span class="cart_item_category"><?php print $cart['category_name']; ?></span>
            <form class="cart-item-del" action="./cart.php" method="post">
              <input type="submit" value="削除">
              <input type="hidden" name="item_id" value="<?php print $cart['item_id']; ?>">
              <input type="hidden" name="sql_kind" value="delete_cart">
            </form>
        </li>
  <?php } ?>
      </ul>
      <div>
  <?php if(count($err_msg) === 0){ ?>
        <form action="./finish.php" method="post">
          <input class="decision-btn" type="submit" value="コーディネート決定">
        </form>
  <?php }else{ ?>
        <form action="./top.php" method="post">
              <input class="decision-btn" type="submit" value="アイテム一覧へ">
            </form>
  <?php } ?>
      </div>
    </div>
  </main>
</body>
</html>
