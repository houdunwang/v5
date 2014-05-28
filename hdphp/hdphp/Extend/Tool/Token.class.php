<?php

// .-----------------------------------------------------------------------------------
// |  Software: [HDPHP framework]
// |   Version: 2013.03
// |      Site: http://www.hdphp.com
// |-----------------------------------------------------------------------------------
// |    Author: 向军 <houdunwangxj@gmail.com>
// | Copyright (c) 2012-2013, http://houdunwang.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------
// |   License: http://www.apache.org/licenses/LICENSE-2.0
// '-----------------------------------------------------------------------------------
final class Token
{

    public static $key = "houdunwang.com";

    /**
     * 创建令牌
     */
    static function create()
    {
        if (!is_null(session(C("TOKEN_NAME")))) {
            return session(C("TOKEN_NAME"));
        }
        $k = self::$key . mt_rand(1, 10000) . NOW . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'];
        session(C("TOKEN_NAME"), md5($k));
    }

    /**
     * 验证令牌
     */
    static function check()
    {
        $tokenName = C("TOKEN_NAME");
        $key = session($tokenName);
        $cli_token = isset($_POST[$tokenName]) ? $_POST[$tokenName] :
            (isset($_GET[$tokenName]) ? $_GET[$tokenName] : NULL);
        return !is_null($key) && !is_null($cli_token) && ($key === $cli_token);
    }

}

?>
