<?php
if (!defined("HDPHP_PATH"))
    exit('No direct script access allowed');
// .-----------------------------------------------------------------------------------
// |  Software: [HDPHP framework]
// |   Version: 2013.01
// |      Site: http://www.hdphp.com
// |-----------------------------------------------------------------------------------
// |    Author: 向军 <houdunwangxj@gmail.com>
// | Copyright (c) 2012-2013, http://houdunwang.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------
// |   License: http://www.apache.org/licenses/LICENSE-2.0
// '-----------------------------------------------------------------------------------
header("Content-Type: text/html; charset=utf-8");
if (METHOD == "hd_uploadify_del") {
    $files = array_filter(explode("@@", $_POST['file']));
    foreach ($files as $f) {
        @unlink($f);
    }
    echo 1;exit;
}
//是否加水印
$water = $_POST['water'];
if ($water == 1) {
    C("WATER_ON", true);
} elseif ($water == 0) {
    C("WATER_ON", false);
}
C("UPLOAD_THUMB_ON", false); //关闭生成缩略图
$upload_dir=isset($_POST['upload_dir'])?$_POST['upload_dir']:"";
$data = array();
$upload = new upload($upload_dir);
$file = $upload->upload();
if ($file) {
    $data['stat'] = 1;
    $data['url'] = __ROOT__ . '/' . $file[0]['path'];
    $data['path'] = $file[0]['path'];
    $data['name'] = $file[0]['name'];
    $data['isimage'] = in_array(strtolower($file[0]['ext']), array("gif", "png", "jpeg", "jpg")) ? 1 : 0;
    $data['thumb'] = array(); //缩略图文件
    if (isset($_POST['hdphp_upload_thumb'])) {
        $size = explode(",", $_POST['hdphp_upload_thumb']); //获得缩略数数量
        $fileInfo = pathinfo($data['path']); //获得文件名信息
        $image = new Image();
        $id = 0; //缩略图ID
        $thumbFile = array(); //缩略图
        $saveDir = dirname($data['path']);
        for ($i = 0, $total = count($size); $i < $total;) {
            $toFile = $fileInfo['filename'] . '_' . $size[$i] . 'x' . $size[$i+1] . '.' . $fileInfo['extension'];
            $thumbFile[] = $saveDir . '/' . $toFile;
            $image->thumb($data['path'], $toFile, $size[$i], $size[$i+1]);
            $i+=2;
        }
        $data['thumb'] = $thumbFile;
    }
} else {
    $data['stat'] = 0;
    $data['msg'] = $upload->error;
}
echo json_encode($data);
exit;
?>