<?php

/**
 * 内容Tag管理
 * Class TagModel
 */
class TagModel extends ViewModel
{
    public $table = "tag";

    public function __init()
    {
    }

    //关联表
    public $view = array(
        'content_tag' => array(
            'type' => INNER_JOIN, //指定连接方式
            'on' => 'tag.tid=content_tag.tid', //关联条件
        )
    );

    /**
     * 用于添加文章时设置tag标签
     * @param null $tag 标签名
     */
    public function add_tag($tag = null)
    {
        $tag = $tag ? $tag : Q('tag');
        $db = M('tag');
        if ($this->create() && $tag) {
            $field = $db->where("tag='$tag'")->find();
            if ($field) {
                $db->where("tag='$tag'")->save(array("total" => $field['total'] + 1));
                return $field['tid'];
            } else {
                return $db->add(array("tag" => $tag, "total" => 1));
            }

        }
    }

    /**
     * 删除标签
     * @param $tid
     * @return boolean
     */
    public function del_tag($tid)
    {
        if ($this->del($tid)) {
            $this->table('content_tag')->where("tid=$tid")->del();
            return true;
        }
    }
}