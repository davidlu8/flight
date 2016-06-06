<?php
class Load {
    public static function model($name) {
        $name = strtolower($name);
        $modelFilePath = sprintf('%smodels/%s.model.php', APPPATH, $name);
        if (!file_exists($modelFilePath)) {
            die("Control class does not exist : ".$modelFilePath);
        }
        require_once($modelFilePath);
        $modelName = sprintf('%sModel', ucfirst($name));
        return new $modelName();
    }
}