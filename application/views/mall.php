<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>积分商城</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="/packages/flatui/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="/packages/flatui/css/flat-ui-pro.min.css">
    <link rel="stylesheet" href="/page/theme/styles/styles.css">
    <script type="text/javascript" charset="utf-8" src="/packages/jquery/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/page/theme/scripts/script.js"></script>
</head>
<body class="mall">
<header class="mall">
    <div class="row">
        <div class="col-xs-6"><span class="block">积分余额：<span class="text-warning"><?php echo $userattr['USERATTR_CREDIT'] ?></span></span></div>
        <div class="col-xs-6 text-right"><a href="/mall/exchange" class="block text-primary">兑换记录</a></div>
    </div>
</header>
<ul class="mall-listblock">
    <li></li>
</ul>
</body>
</html>