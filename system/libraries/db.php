<?php
class DB {
    private static $database;
    private static $config;
    private static $debug = true;
    private static $lastQuery = '';
    public static $marker = array();
    public static function database() {
        return self::$database;
    }

    public static function initialize() {
        $configFilePath = APPPATH.'config/database.php';
        if (!file_exists($configFilePath)) {
            die('The database files does not exist');
        }
        self::$config = require_once($configFilePath);
        foreach(self::$config as $index => $config) {
            if ($config['autoload']) {
                self::connect($config, $index);
            }
        }
    }

    public function __clone(){
        die('Clone is not allow!');
    }

    public static function load($index = 0) {
        if (isset(self::$config[$index])) {
            self::connect(self::$config[$index], $index);
        } else {
            die("The database config does not exist");
        }
        return;
    }

    private static function connect($config, $index = 0) {
        $connectString = sprintf('mysql:host=%s;port=%s;dbname=%s', $config['hostname'], $config['hostport'], $config['database']);
        self::$database[$index] = new PDO($connectString, $config['username'], $config['password']);
        self::$database[$index]->query('set names utf8mb4;');
        self::$database[$index]->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        //self::$database[$index]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function lastInsertId($index = 0) {
        return self::$database[$index]->lastInsertId();
    }

    /**
     * 作用:執行INSERT\UPDATE\DELETE
     * 返回:执行語句影响行数
     * 类型:数字
     */
    public static function execute($sql, $index = 0) {
        if (self::$debug)	{
            $startTime = Common::getMicrotime();
        }

        self::$lastQuery = $sql;
        $result = self::$database[$index]->prepare($sql);
        self::getPDOError($sql);
        $result->execute();

        if (self::$debug) {
            $endTime = Common::getMicrotime();
            $elapsedTime = number_format($endTime - $startTime, 4);
            self::$marker[] = array(
                'host' => self::$config[$index]['hostname'],
                'sql' => $sql,
                'affectedRows' => $result->rowCount(),
                'elapsedTime' => number_format($endTime - $startTime, 4),
            );
        }
    }

    public static function fetch($sql, $type = 0, $index = 0) {
        if (self::$debug)	{
            $startTime = Common::getMicrotime();
        }

        $output = array();
        self::$lastQuery = $sql;
        $result = self::$database[$index]->prepare($sql);
        self::getPDOError($sql);
        $result->execute();

        if (self::$database[$index]->errorCode() == '00000') {
            switch ($type) {
                case '0' :
                    $result->setFetchMode(PDO::FETCH_ASSOC);
                    $output = $result->fetch();
                    break;
                case '1' :
                    $result->setFetchMode(PDO::FETCH_ASSOC);
                    $output = $result->fetchAll();
                    break;
                case '2' :
                    $result->setFetchMode(PDO::FETCH_ASSOC);
                    $output = $result->rowCount();
                    break;
                case '3' :
                    $result->setFetchMode(PDO::FETCH_COLUMN, 1);
                    $output = $result->fetchColumn();
                    break;
                case '4' :
                    $result->setFetchMode(PDO::FETCH_OBJ);
                    $output = $result->fetch();
                    break;
                case '5' :
                    $result->setFetchMode(PDO::FETCH_OBJ);
                    while ($item = $result->fetch()) {
                        $output[] = $item;
                    }
                    break;
            }
        }

        if (self::$debug) {
            $endTime = Common::getMicrotime();
            self::$marker[] = array(
                'host' => self::$config[$index]['hostname'],
                'sql' => $sql,
                'affectedRows' => $result->rowCount(),
                'elapsedTime' => number_format($endTime - $startTime, 4),
            );
        }
        $result = null;

        return $output;
    }

    /**
     * @return 最后执行的sql语句
     */
    public static function lastQuery() {
        return self::$lastQuery;
    }

    /**
     * 對字串進行转義
     */
    public static function quote($str, $index = 0) {
        return self::$database[$index]->quote($str);
    }

    /**
     * 捕获PDO错误信息
     * 返回:出错信息
     * 类型:字串
     */
    private static function getPDOError($mark = '', $index = 0) {
        if (self::$debug && self::$database[$index]->errorCode() != '00000') {
            $error = self::$database[$index]->errorInfo();
            throw new AppException(Errors::ERROR_DATABASE_SQL, $error[2].' | '.$mark);
        }
    }

}
