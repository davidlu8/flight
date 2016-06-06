<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>电视滚动屏</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="/packages/flatui/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="/packages/flatui/css/flat-ui-pro.min.css">
    <link rel="stylesheet" href="/page/theme/styles/styles.css">
    <script type="text/javascript" charset="utf-8" src="/packages/jquery/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/page/theme/scripts/script.js"></script>
</head>
<body>
</body>
<?php echo date('H:i', strtotime($item['GIFTHISTORY_ADD_TIME'])) ?>
<a href="<?php echo $ownerInfo['USERINFO_USER_ID'] ?>" class="text-danger"><?php echo $ownerInfo['USERINFO_NICKNAME'] ?></a>送给了<a href="<?php echo $userInfo['USERINFO_USER_ID'] ?>" class="text-danger"><?php echo $userInfo['USERINFO_NICKNAME'] ?></a><?php echo $gifthistory['GIFTHISTORY_GIFT_AMOUNT'] ?>个<?php echo $gift['GIFT_NAME'] ?>,
掌声响起来...
</html>