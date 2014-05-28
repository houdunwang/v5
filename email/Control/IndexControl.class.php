<?php
//测试控制器类
class IndexControl extends Control{
    function index(){
        //邮件发送处理
        $con= "请点击链接完成注册<a href='http://www.houdunwang.com'>
20             http://www.houdunwang.com";
        $state =Mail::send('464748053@qq.com','464748053@qq.com','这是V5课堂邮件发送测试',$con);
        if($state){
        	echo '发送ok';
        }else{
        	echo '失败了...';
        }
    }
}
?>