<!DOCTYPE html>
<html lang="zh-CN" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>商品兑换</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="/packages/flatui/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="/packages/flatui/css/flat-ui-pro.min.css">
    <link rel="stylesheet" href="/page/theme/styles/styles.css">
    <script type="text/javascript" charset="utf-8" src="/packages/jquery/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/page/theme/scripts/script.js"></script>
</head>
<body class="mall">
<div class="item-wrapper">
    <div class="row">
        <div class="col-xs-6">
            <img src="<?php echo $item['COMMODITY_IMAGE'] ?>"  width="100%" />
        </div>
        <div class="col-xs-6">
            <?php echo $item['COMMODITY_NAME'] ?><br/>
            <span class="gray">话费积分：</span><span class="text-danger"><?php echo number_format($item['COMMODITY_PRICE'], 0) ?></span>
        </div>
    </div>
</div>
<form method="post" action="/mall/exchange">
<div class="desc-title">
    <input type="hidden" name="commodityID" value="<?php echo $item['COMMODITY_ID'] ?>" />
    <?php if ($item['COMMODITY_TYPE'] == 0): ?>
    <input type="text" name="alAccount" class="login-field" value="" placeholder="输入支付宝账号" size="24" /><br/>
    <input type="text" name="alAccount" class="login-field" value="" placeholder="支付宝所有者真实姓名" size="24" /><br/>
    <?php endif ?>
</div>
<div class="desc-wrapper">
    <button class="btn btn-large btn-block btn-danger" name="exchange">确认兑换</button>
</div>
</form>
</body>
</html>