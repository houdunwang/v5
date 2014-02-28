<?php
if (!defined("HDPHP_PATH"))
    exit('No direct script access allowed');
// .-----------------------------------------------------------------------------------
// | Software: [HDPHP framework]
// | Version: 2013.01
// | Site: http://www.hdphp.com
// |-----------------------------------------------------------------------------------
// | Author: 向军 <houdunwangxj@gmail.com>
// | Copyright (c) 2012-2013, http://houdunwang.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------
// | License: http://www.apache.org/licenses/LICENSE-2.0
// '-----------------------------------------------------------------------------------
header("Content-Type: text/html; charset=utf-8");
C("WATER_ON", intval($_GET['water']));
if ($_GET['maximagewidth'] != 'false' || $_GET['maximageheight'] != 'false') {
    //最大图片高度
    $maximageheight = intval($_GET['maximageheight']);
    $maximageheight = $maximageheight ? $maximageheight : C("UPLOAD_IMG_MAX_HEIGHT");
    //最大图片宽度
    $maximagewidth = intval($_GET['maximagewidth']);
    $maximagewidth = $maximagewidth ? $maximagewidth : C("UPLOAD_IMG_MAX_WIDTH");
    C("UPLOAD_IMG_RESIZE_ON", true);
    C("UPLOAD_IMG_MAX_WIDTH", $maximagewidth);
    C("UPLOAD_IMG_MAX_HEIGHT", $maximageheight);
}
//上传图片储存目录
$imgSavePathConfig = array(C('EDITOR_SAVE_PATH'));
//获取存储目录
if (isset($_GET['fetch'])) {
    header('Content-Type: text/javascript');
    echo 'updateSavePath(' . json_encode($imgSavePathConfig) . ');';
    exit;
}
//上传处理
$upload = new upload($imgSavePathConfig[0], '', intval($_GET['uploadsize']));
$title = htmlspecialchars($_POST['pictitle'], ENT_QUOTES);
$file = $upload->upload();
if (!$file) {
    echo "{'title':'" . $upload->error . "','state':'" . $upload->error . "'}";
} else {
    $file['url'] = __ROOT__ . '/' . $file['path'];
    $file["state"] = "SUCCESS";
    echo "{'url':'" . $file['url'] . "','title':'" . $title . "','original':'" . $file["filename"] . "','state':'" . $file["state"] . "'}";
}
exit;