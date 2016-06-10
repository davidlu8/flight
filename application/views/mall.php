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
<header>
    <table class="table">
        <tr>
            <td>积分余额：<span class="text-warning"><?php echo $userattr['USERATTR_CREDIT'] ?></span></td>
            <td class="text-right"><a href="/mall/exchange" class="block text-primary">兑换记录</a></td>
        </tr>
    </table>
</header>

<div class="mall-wrapper">
    <?php foreach($list as $items): ?>
    <div class="rowline">
        <?php foreach($items as $key => $item): ?>
        <div class="<?php echo $key % 2 == 0 ? 'left' : 'right' ?>">
            <div class="block">
                <div class="imageBlock">
                    <img src="<?php echo $item['COMMODITY_IMAGE'] ?>"  width="100%" />
                </div>
                <div class="name">
                    <?php echo $item['COMMODITY_NAME'] ?>
                </div>
                <div class="price">
                    <span class="text-warning"><?php echo $item['COMMODITY_PRICE'] ?>积分</span>
                    <div class="count">
                        <span class="text-disable"><?php echo $item['COMMODITY_COUNT'] ?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach ?>
    </div>
    <div class="clear"></div>
    <?php endforeach ?>
</div>
</body>
</html>