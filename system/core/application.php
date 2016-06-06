<?php
class application {
    private $control;
    private $method;
    private $paras;

    public function __construct() {
    }

    public function run() {
        Fl::logger()->debug("--------------");
        Fl::logger()->debug("[ Controller = " .base::controller()." ] [ IP = ".base::ip()." ] ", base::url());
        Fl::logger()->debug(" Agent : ", $_SERVER['HTTP_USER_AGENT']);

        if (count($_POST) > 0) {
            Fl::logger()->debug(" Post : ", json_encode($_POST));
        }
        if (count($_FILES) > 0) {
            Fl::logger()->debug(" File : ", json_encode($_FILES));
        }

        $control = base::control();
        $method = base::method();
        $paras = base::paras();
        $controlClassFile = APPPATH."controllers/".base::control().".controller.php";
        if (!file_exists($controlClassFile)) {
            Fl::logger()->debug("Control class does not exist ", $controlClassFile);
            die("Control class does not exist : ".$controlClassFile);
        }

        try {
            $controlClass = base::control() . "Control";
            include_once($controlClassFile);
            $this->_control = new $controlClass();
        } catch (Exception $ae) {

        }

    }
}
