<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 2016/6/26
 * Time: 14:18
 */

class tvControl extends baseControl {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
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
}