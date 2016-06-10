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

    public function item($commodity_id) {
        if (!$id = FL::session()->get('id', 0)) {
            header('Location: /mall', 302);
            exit;
        }

        $commodityDal = Load::model('commodity');
        $data['item'] = $commodityDal->find($commodity_id);
        echo '<pre>';
        print_r($item);

        FL::view('mall_item', $data);
    }

    public function history() {

    }

    public function exchange() {

    }
}