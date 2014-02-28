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
 * mysqli数据库驱动
 * @package     Db
 * @subpackage  Driver
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
class DbMysqli extends Db
{
    //是否连接
    static protected $isConnect = false;
    //数据库连接
    public $link = null;

    //获得数据库连接
    public function connectDb()
    {
        if (!self::$isConnect) {
            $link = new mysqli(C("DB_HOST"), C("DB_USER"), C("DB_PASSWORD"), C("DB_DATABASE"), intval(C("DB_PORT")));
            //连接错误
            if (mysqli_connect_errno()) {
                return false;
            }
            self::$isConnect = $link;
            self::setCharset();
        }
        $this->link = self::$isConnect;
        return true;
    }

    /**
     * 设置字符集
     */
    static private function setCharset()
    {
        self::$isConnect->set_charset(C("DB_CHARSET"));
    }

    //获得最后插入的ID号
    public function getInsertId()
    {
        return $this->link->insert_id;
    }

    //获得受影响的行数
    public function getAffectedRows()
    {
        return $this->link->affected_rows;
    }

    //遍历结果集(根据INSERT_ID)
    protected function fetch()
    {
        $res = $this->lastQuery->fetch_assoc();
        if (!$res) {
            $this->resultFree();
        }
        return $res;
    }
    //数据安全处理
    public function escapeString($str)
    {
        if ($this->link) {
            return $this->link->real_escape_string($str);
        } else {
            return addslashes($str);
        }
    }

    //执行SQL没有返回值
    public function exe($sql)
    {
        //查询参数初始化
        $this->optInit();
        //将SQL添加到调试DEBUG
        $this->debug($sql);
        $this->lastQuery = $this->link->query($sql);
        if ($this->lastQuery) {
            //自增id
            $insert_id = $this->link->insert_id;
            return $insert_id ? $insert_id : true;
        } else {
            $this->error($this->link->error . "\t" . $sql);
            return false;
        }
    }

    //发送查询 返回数组
    public function query($sql)
    {
        $cache_time = $this->cacheTime ? $this->cacheTime : intval(C("CACHE_SELECT_TIME"));
        $cacheName = md5($sql . APP . CONTROL . METHOD);
        if ($cache_time >= 0) {
            $result = S($cacheName, FALSE, null, array("Driver" => "file", "dir" => CACHE_PATH, "zip" => false));
            if ($result) {
                //查询参数初始化
                $this->optInit();
                return $result;
            }
        }
        //SQL发送失败
        if (!$this->exe($sql))
            return false;
        $list = array();
        while (($res = $this->fetch()) != false) {
            $list [] = $res;
        }
        if ($cache_time >= 0 && count($list) <= C("CACHE_SELECT_LENGTH")) {
            S($cacheName, $list, $cache_time, array("Driver" => "file", "dir" => CACHE_PATH, "zip" => false));
        }
        return empty($list) ? NULL : $list;
    }

    //释放结果集
    protected function resultFree()
    {
        if (isset($this->lastQuery)) {
            $this->lastQuery->close();
        }
    }


    // 获得MYSQL版本信息
    public function getVersion()
    {
        return $this->link->server_info;
    }

    //自动提交模式true开启false关闭
    public function beginTrans()
    {
        $stat = func_get_arg(0);
        $this->link->autocommit(!$stat);
    }

    //提供一个事务
    public function commit()
    {
        $this->link->commit();
    }

    //回滚事务
    public function rollback()
    {
        $this->link->rollback();
    }

    // 释放连接资源
    public function close()
    {
        if (self::$isConnect) {
            $this->link->close();
            self::$isConnect = false;
            $this->link = null;
        }
    }

    //析构函数  释放连接资源
    public function __destruct()
    {
        $this->close();
    }

}