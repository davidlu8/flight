<?php
class config {
    public $basePath = APPPATH.'config/';
    function __construct() {
    }

    public function get($name) {
        if (preg_match('#^(\w+)\.(\w+)$#', $name, $array)) {
            $configPath = $this->basePath.$array[1].'.php';
            if (file_exists($configPath)) {
                $config = include($configPath);
                if (isset($config[$array[2]])) {
                    return $config[$array[2]];
                }
            }
        }
        return;
    }
}