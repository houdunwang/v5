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
 * SESSION驱动工厂
 * @package     Session
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
final class SessionFactory {

    public static $sessionFactory = null; //静态工厂实例
    protected $driver = array(); //驱动

    /**
     * 构造函数
     */

    private function __construct() {

    }

    /**
     * 返回工厂实例，单例模式
     */
    public static function factory() {
        //只实例化一个对象
        if (is_null(self::$sessionFactory)) {
            self::$sessionFactory = new sessionFactory();
        }
        $driver = ucfirst(strtolower(C("SESSION_ENGINE")));
        if (isset(self::$sessionFactory->driver[$driver])) {
            return self::$sessionFactory->driver[$driver];
        }
        self::$sessionFactory->getDriver($driver);
        return self::$sessionFactory->driver[$driver];
    }

    /**
     * 获得数据库驱动接口
     * @access private
     * @param string $driver
     * @return void
     */
    private function getDriver($driver) {
        $class = 'Session'.ucfirst($driver); //数据库驱动
        $this->driver[$driver] = new $class;
    }

}

?>
