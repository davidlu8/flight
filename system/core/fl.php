<?php
class FL {
    private static $instance;

    public static function __callStatic($funcname, $arguments) {
        if (class_exists($funcname)) {
            if (!isset(self::$instance[$funcname]) || !(self::$instance[$funcname] instanceof $funcname)) {
                switch(count($arguments)) {
                    case 0:
                        self::$instance[$funcname] = new $funcname();
                        break;
                    case 1:
                        self::$instance[$funcname] = new $funcname($arguments[0]);
                        break;
                    case 2:
                        self::$instance[$funcname] = new $funcname($arguments[0], $arguments[1]);
                        break;
                    case 3:
                        self::$instance[$funcname] = new $funcname($arguments[0], $arguments[1], $arguments[2]);
                        break;
                    case 4:
                        self::$instance[$funcname] = new $funcname($arguments[0], $arguments[1], $arguments[2], $arguments[3]);
                        break;
                    case 5:
                        self::$instance[$funcname] = new $funcname($arguments[0], $arguments[1], $arguments[2], $arguments[3], $arguments[4]);
                        break;
                }
            }
            return self::$instance[$funcname];
        } else {
            die('This method is not exists.');
        }
    }
}
