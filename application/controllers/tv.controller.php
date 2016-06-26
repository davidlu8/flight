<?php
class tvControl extends baseControl {
    public function __construct() {
        parent::__construct();
    }

    public function set($id) {
        FL::session()->set('id', $id);
    }

    public function index() {
        $userinfoDal = Load::model('userinfo');
        $gifthistoryDal = Load::model('gifthistory');
        $giftDal = Load::model('gift');
        $filterData = array(
            'select' => ['h.*', 'a.USERATTR_TV'],
            'from' => 't_user_gift_history h',
            'join' => [
                ['t_user_attr a', 'a.USERATTR_USER_ID = h.GIFTHISTORY_OWNER_ID', 'left']
            ],
            'where' => [
                'a.USERATTR_TV >= 0'
            ],
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
        FL::view('tv_help');
    }

    public function settings() {
        if (!$id = FL::session()->get('id', 0)) {
            $data = [
                'errCode' => 1,
                'errMsg' => '用户ID不存在'
            ];
            echo json_encode($data);
            exit;
        }

        $value = FL::input()->get('value', 0);
        $userattrDal = Load::model('userattr');
        $userattr = $userattrDal->find($id);
        if ($userattr['USERATTR_TV'] != $value) {
            $data = array(
                'USERATTR_TV' => $value
            );
            $userattrDal->update($data, "USERATTR_USER_ID = '$id'");
        }

        $data = [
            'errCode' => 0,
            'errMsg' => '',
            'success' => '操作成功',
        ];
        echo json_encode($data);
        exit;

    }
}