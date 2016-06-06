<?php
class homeControl extends baseControl {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $fp = fsockopen('api.yuai6.com', 80, $errno, $errstr, 30);
        if ($fp) {
            $data = array(
                'service' => 'user.info',
                'id' => 100070,
                'type' => 0,
            );
            fputs($fp, 'POST /api.php HTTP/1.1\r\n');
            fputs($fp, 'Host: api.yuai.com\r\n');
            fputs($fp, 'Connection: Close\r\n\r\n');
            fputs($fp, http_build_query($data));
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