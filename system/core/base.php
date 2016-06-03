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
                        require_once($dir.$file);
                    }
                }
                closedir($handle);
            }
        } else {
            die('此目录不存在');
        }
    }

    /**
     * IP地址获取
     * @return string 如：192.168.1.1 失败的情况下，返回空
     */
    public static function getIp() {
        if(!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $cip = $_SERVER["HTTP_CLIENT_IP"];
        } else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if(!empty($_SERVER["REMOTE_ADDR"])) {
            $cip = $_SERVER["REMOTE_ADDR"];
        } else {
            $cip = '';
        }
        preg_match("/[\d\.]{7,15}/", $cip, $cips);
        $cip = isset($cips[0]) ? $cips[0] : 'unknown';
        unset($cips);
        return $cip;
    }

    public static function currentPath() {
        $path = sprintf('http://%s', $_SERVER['HTTP_HOST']);
        $path .= !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $path .= !empty($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : '';
        return $path;
    }
}