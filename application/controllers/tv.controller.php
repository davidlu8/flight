<?php
class tvControl extends baseControl {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $userinfoDal = Load::model('userinfo');
        $gifthistoryDal = Load::model('gifthistory');
        $giftDal = Load::model('gift');
        $filterData = array(
            'order' => array(
                'GIFTHISTORY_ADD_TIME' => 'desc',
            )
        );
        $item = $gifthistoryDal->item($filterData);

        $data = [
            'ownerInfo' => $userinfoDal->find($item['GIFTHISTORY_OWNER_ID']),
            'userInfo' => $userinfoDal->find($item['GIFTHISTORY_USER_ID']),
            'gift' => $giftDal->find($item['GIFTHISTORY_GIFT_ID']),
            'item' => $gifthistoryDal->item($filterData),
        ];

        FL::view('tv_index', $data);
    }

    public function help() {
        $data = [];
        FL::view('tv_help', $data);
    }
}