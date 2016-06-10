<?php
class FL {
    private static $instance;

    public static function __callStatic($funcname, $arguments) {
        if (class_exists($funcname)) {
            if (!isset(self::$instance[$funcname]) || !(self::$instance[$funcname] instanceof $funcname)) {
                echo '<pre>';
                print_r($arguments);
                self::$instance[$funcname] = new $funcname($arguments);
            }
            return self::$instance[$funcname];
        } else {
            die('This method is not exists.');
        }
    }
}
