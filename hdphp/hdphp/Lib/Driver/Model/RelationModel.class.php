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
 * 关联模型
 * @package     Model
 * @subpackage  Driver
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
//关联常量定义
defined("HAS_ONE")      or define("HAS_ONE", "HAS_ONE");
//一对多 主表 VS 从表  用户表（主表）  VS  用户信息表
defined("HAS_MANY")     or define("HAS_MANY", "HAS_MANY");
//一对多  从表 VS 主表 用户信息表（主表） VS  用户表
defined("BELONGS_TO")   or define("BELONGS_TO", "BELONGS_TO");
//多对多
defined("MANY_TO_MANY") or define("MANY_TO_MANY", "MANY_TO_MANY");
class RelationModel extends Model
{
    //关联模型定义
    public $join = array();

    //本次需要关联的表
    private function check_join($table)
    {
        //验证表
        if (!empty($this->joinTable) && !in_array($table, $this->joinTable)) {
            return false;
        } else {
            return true;
        }

    }
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
    //验证关联定义
    private function checkJoinSet($set)
    {
        if (empty($set['type']) || !in_array($set['type'], array(HAS_ONE, HAS_MANY, BELONGS_TO, MANY_TO_MANY))
        ) {
            error("关联定义规则[type]设置错误");
            return false;
        }
        if (empty($set['foreign_key'])) {
            error("关联定义规则[foreign_key]设置错误");
            return false;
        }
        if (empty($set['parent_key'])) {
            error("关联定义规则[parent_key]设置错误");
            return false;
        }
        return true;
    }

    //关联查询
    public function select($data = array())
    {
        $trigger=$this->trigger;
        $this->trigger=true;
        //主表主键
        $pri = $this->db->pri;
        $result = call_user_func(array($this->db, __FUNCTION__), $data);
        //插入失败或者没有定义关联join属性
        if (!$result || $this->joinTable===false || empty($this->join) || !is_array($this->join)) {
            $this->error = $this->db->error;
            $trigger and $this->__after_select($result);
            $this->init();
            return $result;
        }
        //关联操作
        foreach ($this->join as $table => $set) {
            //本次需要关联的表
            if (!$this->check_join($table)) continue;
            //验证关联定义
            if (!$this->checkJoinSet($set)) continue;
            //必须定义foreign_key 与 parent_key
            $fk = $set['foreign_key'];
            $pk = $set['parent_key'];
            //关联表对象
            $db = M($table);
            //附表字段
            $field = "";
            if (isset($set['field'])) {
                $field = $set['field'];
            }
            switch ($set['type']) {
                //一对一
                case HAS_ONE:
                    foreach ($result as $n => $d) {
                        $s = $db->field($field)->where($fk . '=' . $d[$pri])->find();
                        if (is_array($s)) {
                            $result[$n] = array_merge($d, $s);
                        }
                    }
                    break;
                case HAS_MANY:
                    foreach ($result as $n => $d) {
                        $s = $db->field($field)->where($fk . '=' . $d[$pri])->all();
                        if (is_array($s)) {
                            $result[$n][$table] = $s;
                        }
                    }
                    break;
                case BELONGS_TO:
                    foreach ($result as $n => $d) {
                        $s = $db->field($field)->where($pk . '=' . $d[$fk])->find();
                        if (is_array($s)) {
                            $result[$n] = array_merge($d, $s);
                        }
                    }
                    break;
                case MANY_TO_MANY:
                    if (!isset($set['relation_table'])) break;
                    foreach ($result as $n => $d) {
                        $s = $db->table($set['relation_table'])->field($fk)->where($pk . '=' . $d[$pri])->all();
                        if (is_array($s)) {
                            $_id = array();
                            foreach ($s as $_s) {
                                $_id[] = $_s[$fk];
                            }
                            $result[$n][$table] = $db->table($table)->in($_id)->all();
                        }
                    }
                    break;
            }
        }
        $this->error = $this->db->error;
        $trigger and $this->__after_select($result);
        $data = empty($result) ? null : $result;
        $this->init();
        return $data;
    }

    //关联插入
    public function insert($data = array(), $type = "INSERT")
    {
        $this->data($data);
        $data = $this->data;
        $trigger=$this->trigger;
        $trigger and $this->__before_insert($data);
        if (empty($data)) {
            $this->error = "没有任何数据用于INSERT！";
            $this->init();
            $this->data=array();
            $this->trigger=true;
            return false;
        }
        $id = call_user_func(array($this->db, __FUNCTION__), $data, $type);
        //插入失败或者没有定义关联join属性
        if (!$id || $this->joinTable===false || empty($this->join) || !is_array($this->join)) {
            $this->error = $this->db->error;
            $trigger and $this->__after_insert($id);
            $this->init();
            $this->data=array();
            $this->trigger=true;
            return $id;
        }
        $result_id = array();
        $result_id[$this->table] = $id;
        //处理表关联
        foreach ($this->join as $table => $set) {
            //有无操作数据
            if (empty($data[$table]) || !is_array($data[$table])) continue;
            //检测是否需要关联
            if (!$this->check_join($table)) continue;
            //验证关联定义
            if (!$this->checkJoinSet($set)) continue;
            $fk = $set['foreign_key'];
            $pk = $set['parent_key'];
            //关联表对象
            $db = M($table);
            switch ($set['type']) {
                //一对一
                case HAS_ONE:
                    $data[$table][$fk] = $id;
                    $result_id[$table] = $db->insert($data[$table], $type);
                    break;
                case HAS_MANY:
                    $result_id[$table] = array();
                    foreach ($data[$table] as $d) {
                        if (is_array($d)) {
                            $d[$fk] = $id;
                            $result_id[$table][] = $db->insert($d, $type);
                        }
                    }
                    break;
                case BELONGS_TO:
                    $_id = $db->add($data[$table]);
                    $db->table($this->table)->where("id=" . $id)->save(array($fk => $_id));
                    $result_id[$table] = $_id;
                    break;
                case MANY_TO_MANY:
                    if (!isset($set['relation_table'])) break;
                    //关联表
                    $_id = $db->add($data[$table]);
                    $result_id[$table] = $_id;
                    //中间表
                    $_r_id = $db->table($set['relation_table'])->insert(array($pk => $id, $fk => $_id), $type);
                    $result_id[$set['relation_table']] = $_r_id;
            }
        }
        $this->error = $this->db->error;
        $result = empty($result_id) ? null : $result_id;
        $trigger and $this->__after_insert($result);
        $this->init();
        $this->data=array();
        $this->trigger=true;
        return $result;
    }

    //关联更新
    public function update($data = array())
    {
        $this->data($data);
        $data = $this->data;
        $trigger=$this->trigger;
        $trigger and $this->__before_update($data);
        if (empty($data)) {
            $this->error = "没有任何数据用于UPDATE！";
            $trigger and $this->__after_update(NULL);
            $this->init();
            $this->data=array();
            $this->trigger=true;
            return false;
        }
        $stat = call_user_func(array($this->db, __FUNCTION__), $data);
        //插入失败或者没有定义关联join属性
        if (!$stat || $this->joinTable===false || empty($this->join) || !is_array($this->join)) {
            $this->error = $this->db->error;
            $trigger and $this->__after_update($stat);
            $this->init();
            $this->data=array();
            $this->trigger=true;
            return $stat;
        }
        $pri = $this->db->pri;
        $where = preg_replace('@\s*WHERE@i', '', $this->db->opt_old['where']);
        $_p = M($this->table)->field($pri)->where($where)->find();
        $id = $_p[$pri];
        $result_id = array();
        $result_id[$this->table] = $stat;
        //处理表关联
        foreach ($this->join as $table => $set) {
            //有无操作数据
            if (empty($data[$table]) || !is_array($data[$table])) continue;
            //检测是否需要关联
            if (!$this->check_join($table)) continue;
            //验证关联定义
            if (!$this->checkJoinSet($set)) continue;
            $fk = $set['foreign_key'];
            $pk = $set['parent_key'];
            //关联表对象
            $db = M($table);
            switch ($set['type']) {
                //一对一
                case HAS_ONE:
                    $data[$table][$fk] = $id;
                    $db->where("$fk=$id")->save($data[$table]);
                    break;
                case HAS_MANY:
                    $db->where($fk . '=' . $id)->del();
                    foreach ($data[$table] as $d) {
                        if (is_array($d)) {
                            $d[$fk] = $id;
                            $db->replace($d);
                        }
                    }
                    break;
                CASE BELONGS_TO:
                    //副表数据
                    $temp = $db->table($this->table)->find($id);
                    $data[$table][$pk] = $temp[$fk];
                    $result_id[$table] = $db->save($data[$table]);
                    break;
                case MANY_TO_MANY:
                    if (!isset($set['relation_table'])) break;
                    $result_id[$table] = $db->save($data[$table]);
                    break;
            }
        }
        $this->error = $this->db->error;
        $result = empty($result_id) ? null : $result_id;
        $trigger and $this->__after_update($result);
        $this->init();
        $this->data=array();
        $this->trigger=true;
        return $result;
    }

    //关联删除
    public function delete($data = array())
    {
        $trigger=$this->trigger;
        $this->trigger=true;
        $trigger and $this->__before_delete($data);
        //查找将删除的主表数据，用于副表删除时使用
        $id = M($this->table)->where($data)->select();
        if (!$id) {
            $this->init();
            return true;
        }
        $this->db->opt = $this->db->opt_old;
        $stat = call_user_func(array($this->db, __FUNCTION__));
        //插入失败或者没有定义关联join属性
        if (!$stat || $this->joinTable===false || empty($this->join) || !is_array($this->join)) {
            $this->error = $this->db->error;
            $trigger and $this->__after_delete($stat);
            $this->init();
            return $stat;
        }
        $result_id = array();
        $result_id[$this->table] = $stat;
        //处理表关联
        foreach ($this->join as $table => $set) {
            //检测是否需要关联
            if (!$this->check_join($table)) continue;
            //验证关联定义
            if (!$this->checkJoinSet($set)) continue;
            $fk = $set['foreign_key'];
            $pk = $set['parent_key'];
            //关联表对象
            $db = M($table);
            switch ($set['type']) {
                //一对一 与 一对多
                case HAS_ONE:
                case HAS_MANY:
                    foreach ($id as $p) {
                        $result_id[$table] = $db->where($fk . '=' . $p[$pk])->delete();
                    }
                    break;
                CASE BELONGS_TO:
                    break;
                case MANY_TO_MANY:
                    foreach ($id as $p) {
                        $result_id[$table] = $db->table($set['relation_table'])->where($pk . '=' . $p[$pk])->delete();
                    }
                    break;
            }
        }
        $this->error = $this->db->error;
        $result = empty($result_id) ? null : $result_id;
        $trigger and $this->__after_delete($result);
        $this->init();
        return $result;
    }
}
































