<?php
class base {
    public static function autoRequire($dir, $exclude = array()) {
        if (!preg_match('/.+\/$/', $dir)) {
            $dir .= '/';
        }
        if (is_dir($dir)) {
            if ($handle = opendir($dir)) {
                while (($file = readdir($handle)) !== false) {
                    if (filetype($dir.$file) == 'file' && !in_array($file, $exclude)) {
                        echo $dir.$file.'<br/>';
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