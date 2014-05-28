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
 * 视图模型处理类
 * @package     Model
 * @subpackage  Driver
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
defined("INNER_JOIN") or define("INNER_JOIN", "INNER JOIN");
defined("LEFT_JOIN") or define("LEFT_JOIN", "LEFT JOIN");
defined("RIGHT_JOIN") or define("RIGHT_JOIN", "RIGHT JOIN");

class ViewModel extends Model
{
    public $view = array();

    //初始化
    protected function init()
    {
        $opt = array(
            'trigger' => true,
            'joinTable' => array(),
        );
        foreach ($opt as $n => $v) {
            $this->$n = $v;
        }
    }

    //本次需要关联的表
    private function check_join($table)
    {
        //验证表
        if ($this->joinTable === false) {
            return false;
        } else if (is_array($this->joinTable) && !empty($this->joinTable) && !in_array($table, $this->joinTable)) {
            return false;
        } else {
            return true;
        }

    }

    //验证关联定义
    private function checkViewSet($set)
    {
        if (empty($set['type']) || !in_array($set['type'], array(INNER_JOIN, LEFT_JOIN, RIGHT_JOIN))
        ) {
            error("关联定义规则[type]设置错误");
            return false;
        }
        if (empty($set['on'])) {
            error("关联定义规则[on]设置错误");
            return false;
        }
        return true;
    }

    //设置表join关联
    public function setJoinTable()
    {
        //不存在关联定义或不关联时
        if ($this->joinTable === false || empty($this->view)) {
            return;
        }
        //关联from 语句
        $from = " " . $this->tableFull . " ";
        //处理关联
        foreach ($this->view as $table => $set) {
            //表是否需要关联
            if (!$this->check_join($table)) continue;
            //验证关联定义
            if (!$this->checkViewSet($set)) continue;
            //加表前缀
            $_table = C("DB_PREFIX") . $table;
            $from .= $set['type'] . " " . $_table . " ";
            $from .= " ON " . $set['on'] . " ";
        }
        $this->db->opt['table'] = preg_replace('@(\w+?\.[a-z]+?)@i', C('DB_PREFIX') . '\1', $from);
    }

    //查询
    public function select($data = array())
    {
        //设置表关联
        $this->setJoinTable($data);
        $this->init();
        return parent::select($data);
    }

    //count
    public function count($args = "")
    {
        //设置表关联
        $this->setJoinTable();
        $this->init();
        return parent::count($args);
    }

    //min
    public function min($args = "")
    {
        //设置表关联
        $this->setJoinTable();
        $this->init();
        return parent::min($args);
    }

    //max
    public function max($args = "")
    {
        //设置表关联
        $this->setJoinTable();
        $this->init();
        return parent::max($args);
    }

    //max
    public function sum($args = "")
    {
        //设置表关联
        $this->setJoinTable();
        $this->init();
        return parent::sum($args);
    }

    //avg
    public function avg($args = "")
    {
        //设置表关联
        $this->setJoinTable();
        $this->init();
        return parent::max($args);
    }
}


























