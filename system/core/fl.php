<?php
class FL {
    private static $instance;

    public function __callStatic($funcname, $arguments) {
        if (class_exists($funcname)) {

        } else {
            die('This method is not exists.');
        }
    }
}
