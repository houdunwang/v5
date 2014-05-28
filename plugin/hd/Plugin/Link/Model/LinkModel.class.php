<?php

class LinkModel extends ViewModel
{
    //表名
    public $table = 'link';
    //多表关联
    public $view = array(
        'link_type' => array(
            'type' => INNER_JOIN,
            'on' => 'link.tid=link_type.tid'
        )
    );
    /**
     * 添加链接
     * @return mixed
     */
    public function add_link()
    {
        if ($this->create()) {
            //设置Logo
            if (!empty($_FILES['logo'])) {
                $upload = new Upload('upload/link/');
                if ($file = $upload->upload()) {
                    //删除原logo文件
                    $this->data['logo'] = $file[0]['path'];
                }
            }
            return $this->add();
        }
    }

    /**
     * 修改链接
     * @return mixed
     */
    public function edit_link()
    {
        if ($this->create()) {
            //设置Logo
            if (!empty($_FILES['logo'])) {
                $upload = new Upload('upload/link/');
                if ($file = $upload->upload()) {
                    $this->data['logo'] = $file[0]['path'];
                    //删除原logo文件
                    $logo = $this->where('id=' . Q('id'))->getField('logo');
                    if (is_file($logo)) unlink($logo);
                }
            }
            return $this->save();
        }
    }

    /**
     * 删除链接
     */
    public function del_link()
    {
        return $this->del(Q('id'));
    }

}