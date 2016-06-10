<?php
class mallControl extends baseControl {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $id = FL::input()->get('id', 0);
        $timestamp = FL::input()->get('timestamp', 0);
        $sign = FL::input()->get('sign', 0);

        $
        exit;

        $userinfoDal = Load::model('userinfo');
        $gifthistoryDal = Load::model('gifthistory');
        $giftDal = Load::model('gift');
        $filterData = array(
            'order' => array(
                'GIFTHISTORY_ADD_TIME' => 'desc',
            )
        );
        $item = $gifthistoryDal->item($filterData);

        $ownerInfo = $userinfoDal->find($item['GIFTHISTORY_OWNER_ID']);
        $userInfo = $userinfoDal->find($item['GIFTHISTORY_USER_ID']);
        $gift = $giftDal->find($item['GIFTHISTORY_GIFT_ID']);

        require APPPATH.'views/gift.php';
    }
}