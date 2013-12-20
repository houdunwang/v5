<?php
// .-----------------------------------------------------------------------------------
// |  Software: [HDPHP framework]
// |   Version: 2013.01
// |      Site: http://www.hdphp.com
// |-----------------------------------------------------------------------------------
// |    Author: 向军 <houdunwangxj@gmail.com>
// | Copyright (c) 2012-2013, http://houdunwang.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------
// |   License: http://www.apache.org/licenses/LICENSE-2.0
// '-----------------------------------------------------------------------------------

/**
 * 加密解密处理类
 * 适合cookie与session及url加密解密处理
 * @package     tools_class
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */

class Encry {

    static private $auth_key; //加密key
    static private $code = array(); //位运算种子

    //生成加密KEY

    static private function createKey($key) {
        $key = is_null($key) ? C("AUTH_KEY") : $key;
        self::$auth_key = md5($key . $_SERVER['HTTP_USER_AGENT']);
    }

    /**
     * 位加密或解密
     * @param string $string  加密或解密内容
     * @param int $type         类型:1加密 2解密
     */
    static private function cry($string, $type, $key) {
        self::createKey($key);
        $string = $type == 2 ? base64_decode($string) : substr(md5(self::$auth_key . $string), 0, 8) . $string;
        $str_len = strlen($string);
        $data = array();
        $auth_key_length = strlen(self::$auth_key);
        for ($i = 0; $i <= 256; $i++) {
            $data[$i] = ord(self::$auth_key[$i % $auth_key_length]);
        }
        $tmp = '';
        for ($i = $j = 1; $i < 256; $i++) {
            $j = $data[($i + $data[$i]) % 256];
            $tmp = $data[$i];
            $data[$i] = ord($data[$j]);
            $data[$j] = $tmp;
        }
        $code = '';
        $s = '';
        for ($n = $i = $j = 0; $i < $str_len; $i++) {
            $tmp = ($i + ($i % 256)) % 256;
            $j = $data[$tmp] % 256;
            $n = ($tmp + $j) % 256;
            $code = $data[($data[$j] + $data[$n]) % 256];
            $s.=chr(ord($string[$i]) ^ $code);
        }
        if ($type == 1) {
            return str_replace("=", "", base64_encode($s));
        } else {
            if (substr(md5(self::$auth_key . substr($s, 8)), 0, 8) == substr($s, 0, 8)) {
                return substr($s, 8);
            }
            return '';
        }
    }

    /**
     * 加密方法
     * @param string $data    加密字符串
     * @param string $key         密钥
     */
    static public function encrypt($data, $key = null) {
        return self::cry(serialize($data), 1, $key);
    }

    /**
     * 解密方法
     * @param string $string  解密字符串
     * @param string $key     密钥
     */
    static public function decrypt($data, $key = null) {
        return unserialize(self::cry($data, 2, $key));
    }

}

?>