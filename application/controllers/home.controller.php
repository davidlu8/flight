<?php
class homeControl extends baseControl {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $fp = fsockopen('www.warmvoice.cn', 80, $errno, $errstr, 30);
        if ($fp) {
            $param = array(
                'service' => 'user.info',
                'id' => 100070,
                'type' => 0,
            );
            $data = http_build_query($param);
            fputs($fp, 'GET / HTTP/1.0\r\n');
            fputs($fp, 'Host: www.warmvoice.cn\r\n');
            fputs($fp, 'Connection: Close\r\n\r\n');
            $response = '';
            while($row=fread($fp, 4096)){
                $response .= $row;
            }

            fclose($fp);

            echo $response;
        } else {
            die('The host can not open');
        }

    }

    public function test() {
        echo '<pre>';
        print_r($_POST);
    }
}