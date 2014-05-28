<?php

//模板选择（后台文章与栏目更改模板使用）
class TemplateSelectControl extends AuthControl
{
    //选择模板文件（内容页与栏目管理页使用)
    public function select_tpl()
    {
        //模板目录
        $stylePath = ROOT_PATH . 'template/' . C("WEB_STYLE").'/';
        $path = Q("request.path", $stylePath);
        $file = Dir::tree($path, "html");
        foreach ($file as $n => $v) {
            if ($v['type'] == 'dir') {
                $file[$n]['path'] = $v['path'];
            } else {
                $file[$n]['path'] = str_replace($stylePath, '', $v['path']);
            }
        }
        $history = "";
        if ($dir = Q("get.path")) {
            if ($dir == $stylePath) {
                $history = "";
            } else {
                $history = __METH__ . '&path=' . dirname($dir);
            }
        }
        $this->assign("history", $history);
        $this->assign("file", $file);
        $this->display();
    }
}