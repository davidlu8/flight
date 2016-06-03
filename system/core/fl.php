<?php
class FL {
    private static $instance;

    public static function __callStatic($funcname, $arguments) {
        if (class_exists($funcname)) {
            if (!isset(self::$instance[$funcname]) || !(self::$instance[$funcname] instanceof $funcname)) {
                self::$instance[$funcname] = new $funcname($arguments);
            }
            return self::$instance[$funcname];
        } else {
            die('This method is not exists.');
        }
    }

    public static function __get($propname) {
        if (class_exists($propname)) {
            if (!isset(self::$instance[$propname]) || !(self::$instance[$propname] instanceof $propname)) {
                self::$instance[$propname] = new $propname();
            }
            return self::$instance[$propname];
        } else {
            die('This method is not exists.');
        }
    }
}
