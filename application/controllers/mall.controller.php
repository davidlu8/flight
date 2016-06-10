<?php
class mallControl extends baseControl {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $id = FL::input()->get('id', 0);
        $timestamp = FL::input()->get('timestamp', 0);
        $sign = FL::input()->get('sign', '');

        if (Common::makeSign(array($id, $timestamp)) != $sign) {
            //exit('签名不正确');
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

        FL::view('mall', $data);
    }

    public function item($id) {
        echo '<pre>';
        print_r($_SESSION);
    }

    public function history() {

    }

    public function exchange() {

    }
}