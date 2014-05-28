<?php

/**
 * 上传附件管理
 * Class AttachmentControl
 */
class AttachmentControl extends AuthControl
{
    protected $db;

    public function __init()
    {
        $this->db = K("Upload");
    }
	//显示列表
    public function index()
    {
        $count = $this->db->count();
        $page = new Page($count);
        $this->page = $page->show();
        $upload = $this->db->order("id desc")->limit($page->limit())->all();
        if ($upload) {
            foreach ($upload as $id => $v) {
                if ($v['image'] == 1 && is_file($v['path'])) {
                    $upload[$id]['pic'] = __ROOT__ . '/' . $v['path'];
                } else {
                    $upload[$id]['pic'] = __GROUP__ . '/static/img/upload-pic.png';
                }
            }
        }
        $this->upload = $upload;
        $this->display();
    }

    //删除附件
    public function del()
    {
        $id = Q("id", null, "intval");
        if ($id) {
            $file = $this->db->find($id);
            is_file($file['path']) and unlink($file['path']);
            $this->db->del($id);
            $this->ajax(array("state" => 1, "message" => "删除成功!"));
        }
        $this->ajax(array(
            "stat" => 0,
            "msg" => "删除失败!"
        ));
    }
}