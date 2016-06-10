<?php
class session {
    private $sessionData;
    function __construct() {
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->sessionData = $_SESSION;
    }

    public function get($name, $default = '') {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return $default;
        return $this->read($this->request->get(), $name, $default);
    }

    public function set($name, $value) {
        $_SESSION[$name] = $value;
        return;
    }

}
