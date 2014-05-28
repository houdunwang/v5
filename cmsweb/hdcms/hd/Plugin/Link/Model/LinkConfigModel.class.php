<?php

/**
 * 友情链接配置
 * Class LinkConfigModel
 */
class LinkConfigModel extends Model
{
    public $table = 'link_config';


    /**
     * 设置友情链接配置
     */
    public function set_config()
    {
        if ($this->create()) {
            //设置Logo
            if (!empty($_FILES['logo'])) {
                $upload = new Upload('upload/link/');
                if ($file = $upload->upload()) {
                    //新logo文件名
                    $new_logo = $file[0]['dir'] . 'logo' . '.' . $file[0]['ext'];
                    //改名
                    rename($file[0]['path'], $new_logo);
                    $this->data['logo'] = $new_logo;
                }
            }
            return $this->where('id=1')->update();
        }
    }
}