<?php
class uri {
    public $url;
    public $path;
    public $query;
    public $segments = array();
    function __construct() {
        $this->url = substr($_SERVER['REQUEST_URI'], 1);
        $urlInfo = parse_url($this->url);
        $this->path = isset($urlInfo['path']) ? $urlInfo['path'] : '';
        $this->query = isset($urlInfo['query']) ? $urlInfo['query'] : '';
        $this->segments = preg_grep('/[\w]+/', explode('/', $this->path));
        if (!isset($this->segments[0]) || empty($this->segments[0])) {
            $this->segments[0] = 'home';
        }
        if (!isset($this->segments[1]) || empty($this->segments[1])) {
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