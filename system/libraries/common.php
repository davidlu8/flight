<?php
class Common {
    /**
     * 获取微秒
     */
    public static function getMicrotime() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

    /**
     * 随机字符串生成
     * @param int $len 需要随机的长度，不要太长
     * @return string
     */
    public static function createRandStr($len, $type = null) {
        switch($type) {
            case 0:
                $chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                break;
            case 1:
                $chars = 'abcdefghijklmnopqrstuvwxyz';
                break;
            default:
                $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        return substr(str_shuffle(str_repeat($chars, rand(5, 8))), 0, $len);
    }

    /*
     * xml生成
     */
    public static function xmlencode($xmlData) {
        $xmlString = '';
        foreach($xmlData as $item) {
            $xmlString .= '<item>';
            foreach($item as $key => $value) {
                $xmlString .= sprintf('<%s>%s</%s>', $key, $value, $key);
            }
            $xmlString .= '</item>';
        }
        return sprintf('<?xml version="1.0" encoding="UTF-8"?><message>%s</message>', $xmlString);
    }

    /*
    返回状态码 ret
    200：接口正常请求并返回
    4XX：客户端非法请求
    5XX：服务器运行错误,数据库错误
    6XX: 数据校验错误
    700: 业务逻辑错误，根据msg做参考
    */
    public static function makeReturn($ret, $msg, $data = null) {
        if ($data == '') {
            $data = null;
        }
        $arr = null;
        $arr["ret"] = $ret;
        $arr["msg"] = $msg;
        $arr["data"] = $data;
        $return = json_encode($arr, JSON_UNESCAPED_UNICODE);
        $return = str_replace(":null", ":\"\"", $return);

        header("Content-type: text/html; charset=utf-8");
        ob_clean();
        echo($return);
    }

    // 为了输出数据对字段名做映射
    public static function itemMapping(&$data, $name = 'default', $encode = 1) {
        if (!is_array($data)) return $data;
        $map = isset(Map::$data[$name]) ? Map::$data[$name] : array();

        $orignData = $data;
        $data = array();
        $expression = '#[^\w\s\:\-\_\.\/]+#';
        foreach ($orignData as  $key => $item) {
            if (!is_array($item)) {
                if ($encode && is_string($item) && preg_match($expression, $item)) {
                    $item = rawurlencode($item);
                }
                if (array_key_exists($key, $map)) {
                    $data[$map[$key]] = $item;
                } else {
                    $data[self::defaultMapping($key)] = $item;
                }
            } else {
                $newKey = array_key_exists($key, $map) ? $map[$key] : self::defaultMapping($key);
                if (count($item) > 0) {
                    foreach ($item as  $k => $value) {
                        if ($encode && is_string($value) && preg_match($expression, $value)) {
                            $value = rawurlencode($value);
                        }
                        if (array_key_exists($k, $map)) {
                            $data[$newKey][$map[$k]] = $value;
                        } else {
                            $data[$newKey][self::defaultMapping($k)] = $value;
                        }
                    }
                } else {
                    $data[$newKey] = $item;
                }
            }
        }
    }

    public static function defaultMapping($key) {
        $keyData = explode('_', $key);
        if (count($keyData) > 1) {
            unset($keyData[0]);
        }
        return strtolower(implode('', $keyData));
    }

    public static function convertRichLevel($value, $sex = 0) {
        return self::convertLevel($value, BizConfig::$CFG_RICH_LEVEL);
    }

    public static function convertCharmLevel($value, $sex = 0) {
        return self::convertLevel($value, BizConfig::$CFG_CHARM_LEVEL);
    }

    public static function convertLevel($value, $data) {
        $i = 0;
        foreach($data as $name => $iString) {
            $name = intval($name);
            $iArray = explode(',', $iString);
            if ($i == 0 && $iArray[0] != '-∞' && $value < $iArray[0]) {
                return 0;
            }
            if ($iArray[0] == '-∞') {
                if ($value <= $iArray[1]) {
                    return $name;
                }
            } elseif ($iArray[1] == '∞') {
                if ($value >= $iArray[0]) {
                    return $name;
                }
            } else {
                if ($value >= $iArray[0] && $value <= $iArray[1]) {
                    return $name;
                }
            }
            $i++;
        }
        return 0;
    }

    public static function creditChange($paras) {
        $credit = new userData();
        $credit->attach(new userattrOperate());
        $credit->attach(new goldcoinhistoryOperate());
        $credit->attach(new credithistoryOperate());

        $credit->notify($paras);
    }
}