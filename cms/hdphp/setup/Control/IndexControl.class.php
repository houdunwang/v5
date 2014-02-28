<?php

class IndexControl extends AuthControl
{
    function index()
    {
        header('Content-type:text/html;charset=utf-8');
        go('Rbac/index');
    }

    //删除缓存文件
    function delcache()
    {
        $temp = Q('temp', null, 'trim');
        if ($temp && is_dir($temp)) {
            foreach (glob($temp . '/*') as $d)
                Dir::del($d);
        }
        $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $this->success('缓存目录已经全部删除成功', $url);
    }

}