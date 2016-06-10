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
            话费积分：<span class="text-danger"><?php echo number_format($item['COMMODITY_PRICE'], 0) ?></span>
        </div>
    </div>
</div>
<div class="desc-title">
    物品描述
</div>
<div class="desc-wrapper">
    <?php echo $item['COMMODITY_DESC'] ?>
</div>
</body>
</html>