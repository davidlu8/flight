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
                'weight' => 'desc',
                'COMMODITY_ID' => 'desc'
            )
        );
        $data['list'] = $commodityDal->items($filterData);

        FL::view('mall', $data);
    }
}