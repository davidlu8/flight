<?php
class view {
    public $viewFolder = APPPATH.'views/';
    function __construct($viewName, $data) {
        $viewPath = $this->viewFolder.$viewName.'.php';
        if (file_exists($viewPath)) {
            if (count($data) > 0) {
                extract($data);
            }
            include($viewPath);
        } else {
            die('The file of template does not exist!');
        }
    }

}