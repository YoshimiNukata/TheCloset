
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>アイテム登録ページ</title>
  <link type="text/css" rel="stylesheet" href="./css/common.css">
  <link type="text/css" rel="stylesheet" href="./css/admin.css">
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
  <a href="./user_item.php" class="selected">アイテム登録</a>
  <a href="./cart.php">今日のコーディネート</a>
  <a href="./calendar.php">コーディネート一覧表</a>
  <a href="./organize.php">断捨離のススめ</a>
</div>
<main>
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
  <div>
    <a class="nemu" href="./logout.php">ログアウト</a>
  </div>
  <section class="regist_item">
    <h2>アイテム登録</h2>
    <form method="post" enctype="multipart/form-data">
      <div><label><span>ブランド名:</span><input type="text" name="new_name" value=""></label></div>
      <div><label><span>商品画像:</span><input type="file" name="new_img"></label></div>
      <div><label><span>カテゴリー:</span>
        <select name="new_category">
          <option value="">カテゴリー</option>
          <option value="1" >トップス</option>
          <option value="2" >アウター</option>
          <option value="3" >ジャケット</option>
          <option value="4" >パンツ</option>
          <option value="5" >スカート</option>
          <option value="6" >ワンピース</option>
          <option value="7" >スーツ</option>
          <option value="8" >バッグ</option>
          <option value="9" >シューズ</option>
          <option value="10" >アクセサリー</option>
        </select>
        </label>
      </div>
      <input type="hidden" name="sql_kind" value="insert">
      <div class="submit"><input type="submit" value="商品を登録する"></div>
    </form>
  </section>
  <section class="item_list">
    <h2>アイテム情報の一覧・変更</h2>
    <table class="item_table">
      <tr>
        <th>商品画像</th>
        <th>ブランド名</th>
        <th>カテゴリー</th>
        <th>操作</th>
      </tr>
<?php foreach($item_list as $item){ ?>
      <tr>
        <td><img class="img_size" src="./item_img/<?php print $item['img']; ?>"></td>
        <td class="name_width"><?php print $item['name']; ?></td>
        <td>
          <form method="post">
            <select name="change_category" class="change_category">
              <option value="" >カテゴリー</option>
              <option value="1" <?php if((int)$item['category_id'] === 1){ print 'selected'; } ?>>トップス</option>
              <option value="2" <?php if((int)$item['category_id'] === 2){ print 'selected'; } ?>>アウター</option>
              <option value="3" <?php if((int)$item['category_id'] === 3){ print 'selected'; } ?>>ジャケット</option>
              <option value="4" <?php if((int)$item['category_id'] === 4){ print 'selected'; } ?>>パンツ</option>
              <option value="5" <?php if((int)$item['category_id'] === 5){ print 'selected'; } ?>>スカート</option>
              <option value="6" <?php if((int)$item['category_id'] === 6){ print 'selected'; } ?>>ワンピース</option>
              <option value="7" <?php if((int)$item['category_id'] === 7){ print 'selected'; } ?>>スーツ</option>
              <option value="8" <?php if((int)$item['category_id'] === 8){ print 'selected'; } ?>>バッグ</option>
              <option value="9" <?php if((int)$item['category_id'] === 9){ print 'selected'; } ?>>シューズ</option>
              <option value="10" <?php if((int)$item['category_id'] === 10){ print 'selected'; } ?>>アクセサリー</option>
            </select>
            <input type="submit" value="更新" class="category_btn">
            <input type="hidden" name="item_id" value="<?php print $item['item_id']; ?>">
            <input type="hidden" name="sql_kind" value="category">
          </form>
        </td>
        <td>
          <form method="post">
            <input type="submit" value="削除する" class="delert-btn">
            <input type="hidden" name="item_id" value="<?php print $item['item_id']; ?>">
            <input type="hidden" name="sql_kind" value="delete">
          </form>
        </td>
      </tr>
<?php } ?>
    </table>
  </section>
</main>
</body>
</html>
