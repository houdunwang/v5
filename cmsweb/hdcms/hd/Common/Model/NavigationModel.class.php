<?php

/**
 * 前台导航
 * Class NavigationModel
 */
class NavigationModel extends Model
{
    public $table = 'navigation';
    //自动完成
    public $auto = array(
        array('url', '_url', 'method', 2, 3)
    );

    /**
     * 将网址替换为{__ROOT__}
     * 目的是在进行网站迁移时导航链接还是正确的
     * @param $v
     * @return mixed
     */
    protected function _url($v)
    {
       return str_ireplace(__ROOT__, '[ROOT]', $v);
    }

    /**
     * 添加导航
     */
    public function add_nav()
    {
        if ($this->create()) {
            return $this->add();
        }
    }

    /**
     * 修改导航
     * @return mixed
     */
    public function edit_nav()
    {
        if ($this->create()) {
            return $this->save();
        }
    }

    /**
     * 删除导航
     */
    public function del_nav()
    {
        $nid = Q("nid");
        $state = $this->join()->where(array("pid" => $nid))->find();
        if (!$state) {
            return $this->del($nid);
        } else {
            $this->error = '请删除子导航';
            return false;
        }
    }

    /**
     * 更新排序
     */
    public function update_order()
    {
        $menu_order = Q("post.list_order");
        if ($menu_order) {
            foreach ($menu_order as $nid => $order) {
                //排序
                $order = intval($order);
                $this->join()->save(array(
                    "nid" => $nid,
                    "list_order" => $order
                ));
            }
        }
        return true;
    }

    /**
     * 更新缓存
     */
    public function update_cache()
    {
        $nav = $this->order('list_order ASC,nid ASC')->all();
        $data = Data::tree($nav, 'title', 'nid', 'pid');
        return cache('navigation', $data);
    }

    public function __after_insert($data)
    {
        $this->update_cache();
    }

    public function __after_update($data)
    {
        $this->update_cache();
    }

    public function __after_delete($data)
    {
        $this->update_cache();
    }
}