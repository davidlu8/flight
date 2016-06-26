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
<div class="wrapper">
    <?php echo date('H:i', strtotime($item['GIFTHISTORY_ADD_TIME'])) ?>
    <?php echo '<pre>';print_r($item);print_r($ownerInfo) ?>
    <?php if ($item['USERATTR_TV'] == 1): ?>111<span class="text-danger">神秘人</span><?php else: ?>222<a href="userID:<?php echo $ownerInfo['USERINFO_USER_ID'] ?>" class="text-danger"><?php echo $ownerInfo['USERINFO_NICKNAME'] ?></a><?php endif ?>送给了<a href="userID:<?php echo $userInfo['USERINFO_USER_ID'] ?>" class="text-danger"><?php echo $userInfo['USERINFO_NICKNAME'] ?></a><?php echo $item['GIFTHISTORY_GIFT_AMOUNT'] ?>个<span class="text-success">[<?php echo $gift['GIFT_NAME'] ?> <img src="<?php echo $gift['GIFT_IMAGE'] ?>" width="28" />]</span>,
    掌声响起来...<a href="/tv/help" class="text-default title-tv"><img src="/page/theme/images/tv.png" width="20" height="20" /> 我要上电视</a>
</div>
</html>
