<?php
class mallControl extends baseControl {
    public function __construct() {
        parent::__construct();
    }
    public function set($id) {
        FL::session()->set('id', $id);
    }

    public function index() {
    		$sign="";
        if (!$id = FL::session()->get('id', 0)) {
            $id = FL::input()->get('id', 0);
            $timestamp = FL::input()->get('timestamp', 0);
            $sign = FL::input()->get('sign', '');

           // if (Common::makeSign(array($id, $timestamp)) != $sign) {
           //     //exit('签名不正确');
           // }
            FL::session()->set('id', $id);
            FL::session()->set('sign', $sign);
        }
        else
        {
        	$sign= FL::session()->get('sign', '');
        }

				$userDal = Load::model('user');
        $userattrDal = Load::model('userattr');
        
        $items = $userDal->find($id);
        
				$pwd=$items['USER_PASSWORD'];
				if($pwd=="")
					$pwd=md5("");
        $localSign=md5("847se4^273".$id.$pwd);

       	if($localSign!=$sign)
       	{
       			exit("int err");
       	}
        
        
        $data['userattr'] = $userattrDal->find($id);

        $commodityDal = Load::model('commodity');
        $filterData = array(
            'order' => array(
                'COMMODITY_WEIGHT' => 'asc',
                'COMMODITY_PRICE' => 'asc',
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
        if (!$id = FL::session()->get('id', 0)) {
            $data = array(
                'errCode' => 1,
                'errMsg' => '帐号不正确'
            );
            echo json_encode($data);
            exit;
        }

        $userattrDal = Load::model('userattr');
        $data['userattr'] = $userattrDal->find($id);

        $commodityexchangeDal = Load::model('commodityexchange');
        $filterData = array(
            'from' => 't_commodity_exchange e',
            'join' => array(
                array('t_commodity c', 'c.COMMODITY_ID = e.EXCHANGE_COMMODITY_ID', 'left'),
            ),
            'where' => array(
                "EXCHANGE_USER_ID = '$id'"
            ),
            'order' => array(
                'EXCHANGE_ADD_TIME' => 'DESC'
            ),
            'limit' => 20
        );
        $data['items'] = $commodityexchangeDal->items($filterData);

        FL::view('mall_history', $data);
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
        
        
         $data = array(
                   'COMMODITY_COUNT' => ($commodity['COMMODITY_COUNT']+1),
                );
				$commodityDal->update($data, "COMMODITY_ID = '$commodityID'");
				
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

                $data = array(
                    'USERATTR_CREDIT' => $userattr['USERATTR_CREDIT'] - $commodity['COMMODITY_PRICE'],
                );
                $userattrDal->update($data, "USERATTR_USER_ID = '$id'");

                $commodityexchangeDal = Load::model('commodityexchange');
                $data = array(
                    'EXCHANGE_COMMODITY_ID' => $commodity['COMMODITY_ID'],
                    'EXCHANGE_USER_ID' => $userattr['USERATTR_USER_ID'],
                    'EXCHANGE_ALI_ACCOUNT' => $aliAccount,
                    'EXCHANGE_ALI_NAME' => $aliName,
                );
                $commodityexchangeDal->insert($data);

                $credithistoryDal = Load::model('credithistory');
                $data = array(
                    'CREDITHISTORY_TYPE' => 100,
                    'CREDITHISTORY_USER_ID' => $userattr['USERATTR_USER_ID'],
                    'CREDITHISTORY_TITLE' => sprintf('兑换%s商品', $commodity['COMMODITY_NAME']),
                    'CREDITHISTORY_VALUE' => $commodity['COMMODITY_PRICE'],
                );
                $credithistoryDal->insert($data);
                break;
            case 1:
                $vipData = FL::config()->get('app.creditExchangeVip')[$commodity['COMMODITY_VALUE']];
                $data = array(
                    'USERATTR_CREDIT' => $userattr['USERATTR_CREDIT'] - $commodity['COMMODITY_PRICE'],
                    'USERATTR_VIP' => $vipData[0],
                    'USERATTR_VIP_EXPIRETIME' => date('Y-m-d H:i:s', time() + $vipData[1]*24*3600),
                );
                $userattrDal->update($data, "USERATTR_USER_ID = '$id'");

                $commodityexchangeDal = Load::model('commodityexchange');
                $data = array(
                    'EXCHANGE_COMMODITY_ID' => $commodity['COMMODITY_ID'],
                    'EXCHANGE_USER_ID' => $userattr['USERATTR_USER_ID'],
                    'EXCHANGE_ALI_ACCOUNT' => '',
                    'EXCHANGE_ALI_NAME' => '',
                    'EXCHANGE_STATUS' => 1,
                );
                $commodityexchangeDal->insert($data);

                $credithistoryDal = Load::model('credithistory');
                $data = array(
                    'CREDITHISTORY_TYPE' => 100,
                    'CREDITHISTORY_USER_ID' => $userattr['USERATTR_USER_ID'],
                    'CREDITHISTORY_TITLE' => sprintf('兑换%s商品', $commodity['COMMODITY_NAME']),
                    'CREDITHISTORY_VALUE' => $commodity['COMMODITY_PRICE'],
                );
                $credithistoryDal->insert($data);
                break;
            case 2:
                $data = array(
                    'USERATTR_CREDIT' => $userattr['USERATTR_CREDIT'] - $commodity['COMMODITY_PRICE'],
                    'USERATTR_GOLDCOIN' => $userattr['USERATTR_GOLDCOIN'] + $commodity['COMMODITY_VALUE'],
                );
                $userattrDal->update($data, "USERATTR_USER_ID = '$id'");

                $commodityexchangeDal = Load::model('commodityexchange');
                $data = array(
                    'EXCHANGE_COMMODITY_ID' => $commodity['COMMODITY_ID'],
                    'EXCHANGE_USER_ID' => $userattr['USERATTR_USER_ID'],
                    'EXCHANGE_ALI_ACCOUNT' => '',
                    'EXCHANGE_ALI_NAME' => '',
                    'EXCHANGE_STATUS' => 1,
                );
                $commodityexchangeDal->insert($data);

                $credithistoryDal = Load::model('credithistory');
                $data = array(
                    'CREDITHISTORY_TYPE' => 100,
                    'CREDITHISTORY_USER_ID' => $userattr['USERATTR_USER_ID'],
                    'CREDITHISTORY_TITLE' => sprintf('兑换%s商品', $commodity['COMMODITY_NAME']),
                    'CREDITHISTORY_VALUE' => $commodity['COMMODITY_PRICE'],
                );
                $credithistoryDal->insert($data);

                $goldcoinhistoryDal = Load::model('goldcoinhistory');
                $data = array(
                    'GOLDCOINHISTORY_TYPE' => 12,
                    'GOLDCOINHISTORY_USER_ID' => $userattr['USERATTR_USER_ID'],
                    'GOLDCOINHISTORY_TITLE' => sprintf('兑换%s商品', $commodity['COMMODITY_NAME']),
                    'GOLDCOINHISTORY_VALUE' => $commodity['COMMODITY_VALUE'],
                );
                $goldcoinhistoryDal->insert($data);
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