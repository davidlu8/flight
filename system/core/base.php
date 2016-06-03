<?php
class base {
    public static function autoRequire($dir, $exclude = array()) {
        if (is_dir($dir)) {
            if ($handle = opendir($dir)) {
                while (($file = readdir($handle)) !== false) {
                    if (filetype($dir.$file) == 'file' && !in_array($file, $exclude)) {
                        require_once($dir.$file);
                    }
                }
                closedir($handle);
            }
        } else {
            die('此目录不存在');
        }
    }
}