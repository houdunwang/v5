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
C("debug", 0);
C("WATER_ON", intval($_GET['water']));
if ($_GET['maximagewidth'] != 'false' || $_GET['maximageheight'] != 'false') {
    $maximageheight = intval($_GET['maximageheight']);
    $maximagewidth = intval($_GET['maximagewidth']);
    $maximagewidth = $maximagewidth ? $maximagewidth : C("UPLOAD_IMG_MAX_WIDTH");
    $maximageheight = $maximageheight ? $maximageheight : C("UPLOAD_IMG_MAX_HEIGHT");
    C("UPLOAD_IMG_RESIZE_ON", true);
    C("UPLOAD_IMG_MAX_WIDTH", $maximagewidth);
    C("UPLOAD_IMG_MAX_HEIGHT", $maximageheight);
}
$upload = new upload('', '', intval($_GET['uploadsize']));
$title = htmlspecialchars($_POST['pictitle'], ENT_QUOTES);
$file = $upload->upload();
if (!$file) {
    echo "{'title':'" . $upload->error . "','state':'" . $upload->error . "'}";
} else {
    $info = $file[0];
    $info['url'] = __ROOT__ . '/' . $info['path'];
    $info["state"] = "SUCCESS";
    echo "{'url':'" . $info['url'] . "','title':'" . $title . "','original':'" . $info["filename"] . "','state':'" . $info["state"] . "'}";
}
exit;
?>