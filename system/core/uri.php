<?php
class uri {
    public $url;
    public $segments = array();
    function __construct() {
        $this->url = substr($_SERVER['REQUEST_URI'], 1);
        $this->segments = explode('/', $this->url);
        if (empty($this->segments[0])) {
            $this->segments[0] = 'home';
        }
        if (empty($this->segments[1])) {
            $this->segments[1] = 'index';
        }
    }

    public function item($index) {
        if (isset($this->segments[$index])) {
            return $this->segments[$index];
        } else {
            return '';
        }
    }
}