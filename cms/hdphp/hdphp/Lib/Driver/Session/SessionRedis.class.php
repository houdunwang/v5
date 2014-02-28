<?php
if (!defined("HDPHP_PATH"))
    exit('No direct script access allowed');
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

/**
 * 基于Redis的SESSION处理引擎
 * @package         Session
 * @subpackage      Driver
 * @author          后盾向军 <houdunwangxj@gmail.com>
 */
class SessionRedis{

    /**
     * Redis连接对象
     * @access private
     * @var Object
     */
    private $redis;

    function __construct() {
        $config = C("SESSION_REDIS");
        $this->redis = new Redis();
        $this->redis->connect($config['host'], $config['port'], 2.5);
        if (!empty($config['password'])) {
            $this->redis->auth($config['password']);
        }
        $this->redis->select((int) $config['db']);
        session_set_save_handler(
            array(&$this, "open"),
            array(&$this, "close"),
            array(&$this, "read"),
            array(&$this, "write"),
            array(&$this, "destroy"),
            array(&$this, "gc")
        );
    }

    function open() {
        return true;
    }

    /**
     * 获得缓存数据
     * @param string $sid
     * @return void
     */
    function read($sid) {
        $data = $this->redis->get($sid);
        if ($data) {
            $values = explode("|#|", $data);
            return $values[0] === $this->card ? $values[1] : '';
        }
        return $data;
    }

    /**
     * 写入SESSION
     * @param string $sid
     * @param string $data
     * @return void
     */
    function write($sid, $data) {
        return $this->redis->set($sid, $this->card . '|#|' . $data);
    }

    /**
     * 删除SESSION
     * @param string $sid  SESSION_id
     * @return boolean
     */
    function destroy($sid) {
        return $this->redis->delete($sid);
    }

    /**
     * 垃圾回收
     * @return boolean
     */
    function gc() {
        return true;
    }

}

?>
