<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>コーディネート一覧</title>
    <link type="text/css" rel="stylesheet" href="./css/common.css">
    <link type="text/css" rel="stylesheet" href="./css/thecloset.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
    <!-- <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/redmond/jquery-ui.css"> -->
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css">
    <script>
        function history_jump() {
            var ymd = $('#datepicker').val();
            var url = 'http://thecloset.jp/calendar.php';
            if (ymd.length > 0) {
                url = url + '?date=' + ymd;
            }
            location.href = url;
        }
        $(function () {
            $('#datepicker').datepicker();
            $('#ymd_btn').click(history_jump);
        });
    </script>
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
    <a href="./calendar.php" class="selected">コーディネート一覧表</a>
    <a href="./organize.php">断捨離のススめ</a>
</div>
<main>
    <nav>
        <h2>Date</h2>
        <input type="text" id="datepicker">
        <button id="ymd_btn">表示</button>
    </nav>
    <article class="list_article">
<?php foreach($coodinate_list as $key => $value){ ?>
        <div class="calendar_list">
            <h2><?php print $key; ?></h2>
    <?php foreach($value as $keys => $values){ ?>
            <dl>
                <dt>Coodinate No.<?php print $keys; ?></dt>
                <dd class="clearfix">
                    <ul class="item-list">
        <?php foreach($values as $coodinate){ ?>
                        <li>
                            <div class="item">
                                <img class="item-img" src="./item_img/<?php print $coodinate['img']; ?>" >
                                <div class="item-info">
                                    <span class="item-name"><?php print $coodinate['name']; ?></span>
                                    <span class="category_name"><?php print $coodinamte['category_name']?></span>
                                </div>
                            </div>
                        </li>
        <?php } ?>
                    </ul>
                </dd>
            </dl>
    <?php } ?>
        </div>
<?php } ?>
    </article>
</main>
</body>
</html>