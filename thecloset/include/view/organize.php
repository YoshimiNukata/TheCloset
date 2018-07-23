<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>コーディネート一覧</title>
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
    <a href="./organize.php" class="selected">断捨離のススめ</a>
</div>
<main>
<img class="bag_img" src="./images/clean.png">
    <article>
        <div class="clean">
            <h2>断捨離とは</h2>
            <ul>
                <li>断 : 入ってくるいらない物を断つ</li>
                <li>捨 : 家にずっとあるいらない物を捨てる</li>
                <li>離 : 物への執着から離れる。</li>
                <li><a href="https://ja.wikipedia.org/wiki/%E6%96%AD%E6%8D%A8%E9%9B%A2">*ウィキペディア参照</a></li>
            </ul>
        </div>
    </article>
    <article class="orgenize_article">
        <h2>1年以上着用していない洋服です。処分しませんか?</h2>
        <div class="calendar_list">
            <ul class="item-list clearfix">
<?php foreach($organize_list as $organize){ ?>
                <li class="item">
                    <img class="item-img" src="./item_img/<?php print $organize['img']; ?>" >
                    <div class="item-info">
                        <p><?php print $organize['name']; ?></p>
                        <p><?php print $organize['category_name']?></p>
                    </div>
                </li>
 <?php } ?>
            </ul>
        </div>
    </article>
</main>

</body>
</html>