<!DOCTYPE html>
<html lang="zh-CN" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>兑换记录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="/packages/flatui/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="/packages/flatui/css/flat-ui-pro.min.css">
    <link rel="stylesheet" href="/page/theme/styles/styles.css">
    <script type="text/javascript" charset="utf-8" src="/packages/jquery/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/page/theme/scripts/script.js"></script>
</head>
<body class="mall">
<header>
    <table class="table">
        <tr>
            <td>积分余额：<span class="text-warning"><?php echo $userattr['USERATTR_CREDIT'] ?></span></td>
            <td class="text-right"></td>
        </tr>
    </table>
</header>

<ul class="history">
    <?php foreach($items as $item): ?>
    <li>
        兑换<span class="text-danger">[]</span>商品
        <div class="date">
            <?php echo date('m/d', strtotime($item['EXCHANGE_ADD_TIME'])) ?>
        </div>
    </li>
    <?php endforeach ?>
</ul>
</body>
</html>