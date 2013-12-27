<?php
//测试控制器类
class IndexControl extends Control{
    function index(){
        header("Content-type:text/html;charset=utf-8");
        echo "<div style='Font:36px/38px 微软雅黑;margin:35px;color:#333;'>欢迎使用 <b>HDPHP</b></div>";
    }
}
?>