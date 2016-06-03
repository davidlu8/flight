<?php
class FL {
    private static $fl;
    public static function getInstance() {
        return self::$fl;
    }

    public static function uri() {
        if (!isset(self::$fl->uri) || !(self::$fl->uri instanceof uri)) {
            self::$fl->uri = new uri();
        }
        return self::$fl->uri;
    }
}