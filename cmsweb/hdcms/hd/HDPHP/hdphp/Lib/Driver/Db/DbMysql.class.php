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
 * Mysql数据库驱动类
 * @package     Db
 * @subpackage  Driver
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
class DbMysql extends Db
{

    //是否连接
    static protected $isConnect = false;
    public $link = null; //数据库连接

    function connectDb()
    {
        if (!(self::$isConnect)) {
        	if(C('DB_PCONNECT')){
            	$link = mysql_pconnect(C("DB_HOST"), C("DB_USER"), C("DB_PASSWORD"),true);
			}else{
				$link = mysql_connect(C("DB_HOST"), C("DB_USER"), C("DB_PASSWORD"),true,131072);
			}
            if (!$link) {
                return false;
            } else {
                self::$isConnect = $link;
                self::setCharts();
            }
        }
        $this->link = self::$isConnect;
        mysql_select_db(C("DB_DATABASE"), $this->link);
        return true;
    }

    /**
     * 设置字符集
     */
    static private function setCharts()
    {
        $character = C("DB_CHARSET");
        $sql = "SET character_set_connection=$character,character_set_results=$character,character_set_client=binary";
        mysql_query($sql, self::$isConnect);
    }

    //获得最后插入的ID号
    public function getInsertId()
    {
        return mysql_insert_id($this->link);
    }

    //获得受影响的行数
    public function getAffectedRows()
    {
        return mysql_affected_rows($this->link);
    }

    //遍历结果集(根据INSERT_ID)
    protected function fetch()
    {
        $res = mysql_fetch_assoc($this->lastquery);
        if (!$res) {
            $this->resultFree();
        }
        return $res;
    }
    //数据安全处理
    public function escapeString($str)
    {
        if ($this->link) {
            return mysql_real_escape_string($str,$this->link);
        } else {
            return mysql_escape_string($str);
        }
    }
    //执行SQL没有返回值
    public function exe($sql)
    {
        //查询参数初始化
        $this->optInit();
        //将SQL添加到调试DEBUG
        $this->debug($sql);
        is_resource($this->link) or $this->connect($this->table);
        $this->lastquery = mysql_query($sql, $this->link);
        if ($this->lastquery) {
            //自增id
            $insert_id = mysql_insert_id($this->link);
            return $insert_id ? $insert_id : true;
        } else {
            $this->error(mysql_error($this->link) . "\t" . $sql);
            return false;
        }
    }

    //发送查询 返回数组
    public function query($sql)
    {
        $cache_time = $this->cacheTime ? $this->cacheTime : intval(C("CACHE_SELECT_TIME"));
        $cacheName = $sql . APP . CONTROL . METHOD;
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
        return is_array($list) && !empty($list) ? $list : NULL;
    }

    //释放结果集
    protected function resultFree()
    {
        if (isset($this->lastquery)) {
            mysql_free_result($this->lastquery);
        }
        $this->result = null;
    }

    // 获得MYSQL版本信息
    public function getVersion()
    {
        is_resource($this->link) or $this->connect($this->table);
        return preg_replace("/[a-z-]/i", "", mysql_get_server_info());
    }

    //开启事务处理
    public function beginTrans()
    {
        mysql_query("START AUTOCOMMIT=0");
    }

    //提供一个事务
    public function commit()
    {
        mysql_query("COMMIT", $this->link);
    }

    //回滚事务
    public function rollback()
    {
        mysql_query("ROLLBACK", $this->link);
    }

    // 释放连接资源
    public function close()
    {
        if (is_resource($this->link)) {
            mysql_close($this->link);
            self::$isConnect = null;
            $this->link = null;
        }
    }

    //析构函数  释放连接资源
    public function __destruct()
    {
        $this->close();
    }

}