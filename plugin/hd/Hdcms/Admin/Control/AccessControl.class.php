<?php

/**
 * 后台rbac权限管理
 * Class AccessControl
 * @author 向军 <houdunwangxj@gmail.com>
 */
class AccessControl extends AuthControl
{
    //模型
    public $_db;

    public function __init()
    {
        $this->_db = K("Access");
    }

    //设置权限
    public function edit()
    {
        if (IS_POST) {
            $rid = Q("post.rid");
            $this->_db->where(array("rid" => $rid))->del();
            if (!empty($_POST['nid'])) {
                foreach ($_POST['nid'] as $v) {
                    $this->_db->add(
                        array("rid" => $rid, "nid" => $v)
                    );
                }
            }
            $this->_ajax(1, '修改成功');
        } else {
            $rid = Q("rid");
            $sql = "SELECT n.nid,n.title,n.pid,n.type,a.rid as access_rid FROM hd_node AS n LEFT JOIN (SELECT * FROM (SELECT * FROM hd_access WHERE rid=$rid) AS aa)AS a
                ON n.nid = a.nid ORDER BY list_order ASC";
            $result = $this->_db->query($sql);
            foreach ($result as $n => $r) {
                $checked = $r['access_rid'] ||$r['type']==2? " checked=''" : '';
                $disabled=$r['type']==2?'disabled=""':'';
                $result[$n]['checkbox'] = "<label><input type='checkbox' name='nid[]' value='{$r['nid']}' $checked $disabled/> {$r['title']}</label>";
            }
            $this->access = Data::channelLevel($result, 0, '-', 'nid');
            $this->rid = $rid;
            $this->display();
        }
    }
}

?>