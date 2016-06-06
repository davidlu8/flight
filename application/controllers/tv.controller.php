<?php
class tvControl extends baseControl {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $userinfoDal = Load::model('userinfo');
        $gifthistoryDal = Load::model('gifthistory');
        $filterData = array(
            'order' => array(
                'GIFTHISTORY_ADD_TIME' => 'desc',
            )
        );
        $item = $gifthistoryDal->item($filterData);

        $ownerInfo = $userinfoDal->find($item['GIFTHISTORY_OWNER_ID']);
        $userInfo = $userinfoDal->find($item['GIFTHISTORY_USER_ID']);
        $gift = $gifthistoryDal->find($item['GIFT_ID']);
    }
}