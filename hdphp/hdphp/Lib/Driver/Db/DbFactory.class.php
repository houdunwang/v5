<?php

if (!defined("HDPHP_PATH"))
    exit('No direct script access allowed');
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
 * 数据库驱动工厂
 * @package     Db
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
final class DbFactory
{

    public static $dbFactory = null; //静态工厂实例
    protected $driverList = array(); //驱动组

    /**
     * 构造函数
     */

    private function __construct()
    {

    }

    /**
     * 返回工厂实例，单例模式
     */
    public static function factory($driver = null, $tableName = null)
    {
        //只实例化一个对象
        if (is_null(self::$dbFactory)) {
            self::$dbFactory = new dbFactory();
        }
        if (is_null($driver)) {
            $driver = ucfirst(strtolower(C("DB_DRIVER")));
        }
        if (is_null($tableName)) {
            $tableName = 'empty';
        }
        //数据库驱动存在并且数据库连接正常
        if (isset(self::$dbFactory->driverList[$tableName]) && self::$dbFactory->driverList[$tableName]->link) {
            return self::$dbFactory->driverList[$tableName];
        }
        //获得数据库驱动
        if (self::$dbFactory->getDriver($driver, $tableName)) {
            return self::$dbFactory->driverList[$tableName];
        } else {
            return false;
        }
    }

    /**
     * 获得数据库驱动接口
     * @param $driver 驱动
     * @param $tableName 表名
     */
    private function getDriver($driver, $tableName)
    {
        $class = "Db" . $driver; //数据库驱动
        $classFile = HDPHP_DRIVER_PATH . 'Db/Driver/' . $class . '.Tool.php'; //加载驱动类库文件
        require_cache($classFile);
        $this->driverList[$tableName] = new $class;
        $table = $tableName == 'empty' ? null : $tableName;
        return $this->driverList[$tableName]->connect($table);
    }

    /**
     * 释放连接驱动
     */
    private function close()
    {
        foreach ($this->driverList as $db) {
            $db->close();
        }
    }

    /**
     * 析构函数
     */
    function __destruct()
    {
        $this->close();
    }

}
