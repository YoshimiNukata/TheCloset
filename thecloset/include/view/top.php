
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>商品一覧ページ</title>
  <link type="text/css" rel="stylesheet" href="./css/common.css">
  <link type="text/css" rel="stylesheet" href="./css/thecloset.css">
</head>
<body>
  <header>
    <div class="header-box">
      <h1><a class="logo" href="./top.php">THE CLOSET</a></h1>
      <a class="nemu" href="./logout.php">ログアウト</a>
      <p class="nemu"><?php print $user_name; ?>様</p>
    </div>
  </header>
  <div class="top_menu">
    <a href="./user_item.php">アイテム登録</a>
    <a href="./cart.php">今日のコーディネート</a>
    <a href="./calendar.php">コーディネート一覧表</a>
    <a href="./organize.php">断捨離のススめ</a>
  </div>
  <main>
    <nav>
      <h2>カテゴリー</h2>
      <ul>
        <li><a href="?category_id=">全て</a></li>
        <li><a href="?category_id=1">トップス</a></li>
        <li><a href="?category_id=2">アウター</a></li>
        <li><a href="?category_id=3">ジャケット</a></li>
        <li><a href="?category_id=4">パンツ</a></li>
        <li><a href="?category_id=5">スカート</a></li>
        <li><a href="?category_id=6">ワンピース</a></li>
        <li><a href="?category_id=7">スーツ</a></li>
        <li><a href="?category_id=8">バッグ</a></li>
        <li><a href="?category_id=9">シューズ</a></li>
        <li><a href="?category_id=10">アクセサリー</a></li>
      </ul>
    </nav>
    <article class="top_article">
    <h2><?php print $category_name; ?></h2>
    <?php if(count($message) > 0){ ?>
  <ul class="success">
  <?php foreach($message as $value){ ?>
      <li><?php print $value; ?></li>
  <?php } ?>
  </ul>
<?php } ?>
<?php if(count($err_msg) > 0){ ?>
    <ul class="failure">
    <?php foreach($err_msg as $value){ ?>
        <li><?php print $value; ?></li>
    <?php } ?>
    </ul>
<?php } ?>
      <ul class="item-list">
    <?php foreach($item_list as $item){ ?>
        <li>
          <div class="item">
            <form action="./top.php" method="post">
              <img class="item-img" src="./item_img/<?php print $item['img']; ?>" >
              <div class="item-info">
                <span class="item-name"><?php print $item['name']; ?></span>
              </div>
              <input class="square_btn" type="submit" value="今日のコーデに追加">
              <input type="hidden" name="item_id" value="<?php print $item['item_id']; ?>">
              <input type="hidden" name="sql_kind" value="insert_coordinate">
            </form>
          </div>
        </li>
    <?php } ?>
      </ul>
    </article>
  </main>
</body>
</html>
