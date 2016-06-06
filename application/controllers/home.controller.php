<?php
class homeControl extends baseControl {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $fp = fsockopen('api.yuai6.com', 80, $errno, $errstr, 30);
        if (!$fp) {
            fputs($fp, 'POST /api.php HTTP/1.1\r\n');
            fputs($fp, 'Host: api.yuai.com\r\n');
            fputs($fp, 'Connection: Close\r\n\r\n');
            fputs($fp, 'service=user.info&id=1000070&type=0');
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
}