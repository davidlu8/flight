<?php
class application {
    private $control;
    private $method;
    private $paras;

    public function __construct() {
        $this->control = base::control();
        $this->method = base::method();
        $this->paras = base::paras();
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

        $controlClassFile = APPPATH."controllers/".$this->control.".controller.php";
        if (!file_exists($controlClassFile)) {
            Fl::logger()->error("Control class does not exist ", $controlClassFile);
            die("Control class does not exist : ".$controlClassFile);
        }

        DB::initialize();

        try {

            $controlClass = $this->control . "Control";
            include_once($controlClassFile);
            $controlItem = new $controlClass();

            if (method_exists($controlItem, $this->method))
                try {
                    echo '<pre>';
                    print_r($this->paras);
                    call_user_func(array($controlItem, $this->method), $this->paras);
                } catch(Exception $e) {
                    Fl::logger()->error('error method', $e->getCode().'|'.$e->getMessage());
                }
            else {
                Fl::logger()->error("error method", $this->method);
                die("error method : ".$this->method);
            }
        } catch (Exception $e) {
            die("error method : ".$e->getMessage());
        }

    }
}
