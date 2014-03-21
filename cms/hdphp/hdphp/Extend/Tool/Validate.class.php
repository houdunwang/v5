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
 * 表单验证处理类
 * @package     tools_class
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
class Validate
{

    public $error = false; //验证错误信息  初始没有错误信息
    private $rule; //验证规则  数组形式

    //不能为空
    public function _nonull($name, $value, $msg)
    {
        if (empty($value) && $value !== 0) {
            return $msg;
        }
        return true;
    }

    public function _email($name, $value, $msg)
    {
        $preg = "/^([a-zA-Z0-9_\-\.])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/i";
        if (preg_match($preg, $value)) {
            return true;
        }
        return $msg;
    }
    //最大长度
    public function _maxlen($name, $value, $msg, $arg)
    {
        if (!is_numeric($arg)) {
            halt('验证规则的maxlen参数必须为数字');
        }
        if(mb_strlen($value,'utf-8')<=$arg){
            return true;
        }
        return $msg;
    }
    //最小长度
    public function _minlen($name, $value, $msg, $arg)
    {
        if (!is_numeric($arg)) {
            halt('验证规则的minlen参数必须为数字');
        }
        if(mb_strlen($value,'utf-8')>=$arg){
            return true;
        }
        return $msg;
    }

    public function _http($name, $value, $msg, $arg)
    {
        $preg = "/^(http[s]?:)?(\/{2})?([a-z0-9]+\.)?[a-z0-9]+(\.(com|cn|cc|org|net|com.cn))$/i";
        if (preg_match($preg, $value)) {
            return true;
        }
        return $msg;
    }

    public function _tel($name, $value, $msg, $arg)
    {
        $preg = "/(?:\(\d{3,4}\)|\d{3,4}-?)\d{8}/";
        if (preg_match($preg, $value)) {
            return true;
        }
        return $msg;
    }

    public function _phone($name, $value, $msg, $arg)
    {
        $preg = "/^\d{11}$/";
        if (preg_match($preg, $value)) {
            return true;
        }
        return $msg;
    }
    //身份证验证
    public function _identity($name, $value, $msg, $arg)
    {
        $preg = "/^(\d{15}|\d{18})$/";
        if (preg_match($preg, $value)) {
            return true;
        }
        return $msg;
    }
    //用户名验证
    public function _user($name, $value, $msg, $arg)
    {
        $arg = explode(',', $arg);
        $startLen = $arg[0] - 1;
        $preg = "/^[a-zA-Z]\w{" . $startLen . ',' . $arg[1] . "}$/";
        if (preg_match($preg, $value)) {
            return true;
        }
        return $msg;
    }
    //数字范围
    public function _num($name, $value, $msg, $arg)
    {
        $arg = explode(',', $arg);
        if ($value >= $arg[0] && $value <= $arg[1]) {
            return true;
        }
        return $msg;
    }

    public function _regexp($name, $value, $msg, $preg)
    {
        if (preg_match($preg, $value)) {
            return true;
        }
        return $msg;
    }

    public function _confirm($name, $value, $msg, $arg)
    {
        if ($value == $_POST[$arg]) {
            return true;
        }
        return $msg;
    }

    public function _china($name, $value, $msg, $arg)
    {
        if (preg_match('/^[\x{4e00}-\x{9fa5}a-z0-9]+$/ui', $value)) {
            return true;
        }
        return $msg;
    }

}
