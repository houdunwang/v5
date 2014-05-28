<?php
if (!defined("HDPHP_PATH")) exit('No direct script access allowed');
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

/**
 * 系统核心类库包 自动加载优先
 * @package     Core
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
return array(
    "ip" => HDPHP_EXTEND_PATH . 'Org/Ip/Ip.class.php', //IP处理类
    "mail" => HDPHP_EXTEND_PATH . 'Org/Mail/Mail.class.php', //IP处理类
    "UEDITOR_UPLOAD" => HDPHP_EXTEND_PATH . 'Org/Ueditor/php/ueditor_upload.php', //ueditor
    "KEDITOR_UPLOAD" => HDPHP_EXTEND_PATH . 'Org/Keditor/php/upload_json.php', //keditor
    "HD_UPLOADIFY" => HDPHP_EXTEND_PATH . 'Org/Uploadify/hd_uploadify.php', //uploadify上传
    "HD_UPLOADIFY_DEL" => HDPHP_EXTEND_PATH . 'Org/Uploadify/hd_uploadify.php', //uploadify删除
    "editorCatcherUrl" => HDPHP_EXTEND_PATH . 'Org/Editor/Ueditor/php/ueditorCatcherUrl.php', //ueditor,
);
?>
