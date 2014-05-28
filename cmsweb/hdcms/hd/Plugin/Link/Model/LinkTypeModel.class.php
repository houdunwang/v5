<?php

/**
 * 友情链接配置
 * Class LinkConfigModel
 */
class LinkTypeModel extends Model
{
    public $table = 'link_type';

    /**
     * 添加分类
     * @return mixed
     */
    public function add_type()
    {
        if ($this->create()) {
            return $this->add();
        }
    }

    /**
     * 修改分类
     * @return mixed
     */
    public function edit_type()
    {
        if ($this->create()) {
            return $this->save();
        }
    }

    /**
     * 删除分类
     */
    public function del_type()
    {
        $tid = Q('tid', NULL, 'intval');
        $this->del($tid);
        $sql = "UPDATE " . C('DB_PREFIX') . "link SET tid=2 WHERE tid=$tid";
        return $this->exe($sql);
    }
}