<?php
class mallControl extends baseControl {
    public function __construct() {
        parent::__construct();
    }
    public function set($id) {
        FL::session()->set('id', $id);
    }

    public function index() {
        if (!$id = FL::session()->get('id', 0)) {
            $id = FL::input()->get('id', 0);
            $timestamp = FL::input()->get('timestamp', 0);
            $sign = FL::input()->get('sign', '');

            if (Common::makeSign(array($id, $timestamp)) != $sign) {
                //exit('签名不正确');
            }
            FL::session()->set('id', $id);
        }

        $userattrDal = Load::model('userattr');
        $data['userattr'] = $userattrDal->find($id);

        $commodityDal = Load::model('commodity');
        $filterData = array(
            'order' => array(
                'COMMODITY_WEIGHT' => 'desc',
                'COMMODITY_ID' => 'desc'
            )
        );
        $list = array();
        foreach($commodityDal->items($filterData) as $key => $item) {
            $newKey = intval($key / 2);
            $list[$newKey][] = $item;
        }
        $data['list'] = $list;

        FL::view('mall_index', $data);
    }

    public function item($commodityID) {
        if (!$id = FL::session()->get('id', 0)) {
            header('Location: /mall', 302);
            exit;
        }

        $commodityDal = Load::model('commodity');
        $data['item'] = $commodityDal->find($commodityID);

        FL::view('mall_item', $data);
    }

    public function confirm($commodityID) {
        if (!$id = FL::session()->get('id', 0)) {
            header('Location: /mall', 302);
            exit;
        }

        $commodityDal = Load::model('commodity');
        $data['item'] = $commodityDal->find($commodityID);

        FL::view('mall_confirm', $data);
    }

    public function history() {

    }

    public function exchange() {
        if (!$id = FL::session()->get('id', 0)) {
            $data = array(
                'errCode' => 1,
                'errMsg' => '帐号不正确'
            );
            echo json_encode($data);
            exit;
        }
        $commodityID = FL::input()->post('commodity_id', 0);

        $userattrDal = Load::model('userattr');
        $userattr = $userattrDal->find($id);
        $commodityDal = Load::model('commodity');
        $commodity = $commodityDal->find($commodityID);
        if ($userattr['USERATTR_CREDIT'] < $commodity['COMMODITY_PRICE']) {
            $data = array(
                'errCode' => 1,
                'errMsg' => '你的积分不足'
            );
            echo json_encode($data);
            exit;
        }

        switch($commodity['COMMODITY_TYPE']) {
            case 0:
                if (!$aliAccount = FL::input()->post('ali_account', '')) {
                    $data = array(
                        'errCode' => 1,
                        'errMsg' => '支付宝账号不能为空'
                    );
                    echo json_encode($data);
                    exit;
                }
                if (!$aliName = FL::input()->post('ali_name', '')) {
                    $data = array(
                        'errCode' => 1,
                        'errMsg' => '支付宝所有者真实姓名不能为空'
                    );
                    echo json_encode($data);
                    exit;
                }

                $commodityexchangeDal = Load::model('commodityexchange');
                $data = array(
                    'EXCHANGE_COMMODITY_ID' => $commodity['COMMODITY_ID'],
                    'EXCHANGE_USER_ID' => $userattr['USERATTR_USER_ID'],
                    'EXCHANGE_ALI_ACCOUNT' => $aliAccount,
                    'EXCHANGE_ALI_NAME' => $aliName,
                );
                $commodityexchangeDal->insert($data);
                break;
            case 1:
                break;
            case 2:
                break;
        }


        $data = array(
            'errCode' => 0,
            'errMsg' => '',
            'success' => '兑换成功'
        );
        echo json_encode($data);
    }
}