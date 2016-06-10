<?php
class input {
    public $escape = true;
    private $request;
    function __construct() {
        $this->request = new request();
    }

    private function read($data, $name, $default = '') {
        if ($data instanceof requestBase) {
            foreach(array('get', 'post', 'files') as $func) {
                $theData = call_user_func_array(array($data, $func), array());
                if (isset($theData[$name])) {
                    return $theData[$name];
                }
            }
            return $default;
        } else {
            if (isset($data[$name])) {
                return $data[$name];
            }
            return $default;
        }
    }

    public function get($name, $default = '') {
        return $this->read($this->request->get(), $name, $default);
    }

    public function post($name, $default = '') {
        return $this->read($this->request->post(), $name, $default);

    }

    public function file($name, $default = '') {
        return $this->read($this->request->files(), $name, $default);

    }

    public function all($name, $default = '') {
        return $this->read($this->request, $name, $default);
    }
}

interface requestBase {
    public function get();
    public function post();
    public function files();
}

class request implements requestBase {
    public $getData;
    public $postData;
    public $filesData;
    function __construct() {
        $this->getData = $_GET;
        $this->postData = $_POST;
        $this->filesData = $_FILES;
    }

    public function get() {
        return $this->getData;
    }

    public function post() {
        return $this->postData;
    }

    public function files() {
        return $this->filesData;
    }

}
