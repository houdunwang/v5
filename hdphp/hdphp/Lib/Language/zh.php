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
 * UTF8中文语言包
 * @package     Language
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
//命令 方法(函数)名__所在行代码段
return array(
    //函数库HDPHP/Lib/Core/funtions.php
    'functions_k_is_file' => '模型文件不存在',
    'functions_k_error' => '模型类不存在',
    'functions_control_error' => ' 控制器文件中没有定义类',
    'functions_load_file_debug' => '文件不存在',
    'functions_error_debug' => '查看详细错误信息方法有两种： ① 查看网站日志文件  ② 开启调试模式',
    //函数库HDPHP/Lib/Core/control.php
    "control_error_msg" => "出错了",
    "control_success_msg" => "操作成功",
    //HDPHP/HD.PHP
    //'hd_mkdirs_app_group'=> '应用组目录创建失败，请修改权限！',
    'hd_mkdirs_path_temp' => '临时目录创建失败，请修改权限！',
    'hd_mkdirs_path_log' => '日志目录创建失败，请修改权限！',
    'hd_mkdirs_path_session' => 'SESSION目录目录创建失败，请修改权限！',
    'mysql_insert_error' => '没有任何数据要插入,系统会将$_POST值自动插入，也可以手动将数据传入或者用ORM方式，请查看HD手册学习',
    'mysql_insert_error2' => '插入数据错误，原因可能为1：插入内容为空   2：字段名非法，看一下HD框架手册吧！',
    'mysql_update_error1' => '没有任何数据要更新,系统会将$_POST值自动更新，也可以手动将数据传入或者用ORM方式，请查看HD手册学习',
    'mysql_where_error' => '的参数没有设置，如果不清楚使用方式请查看HD手册学习',
    'mysql_in_error' => '的参数不能为空，如果不清楚使用方式请查看HD手册学习',
    'mysql_field_error' => '的参数不能为空，如果不清楚使用方式请查看HD手册学习',
    //HDPHP/Lib/usr/Db/Driver/mysqliDriver.php

    //HDPHP/Lib/usr/Model/Model.Class.php
    "model__call_error" => '模型中不存在方法',
    "model_update_error" => '悲剧了。。。更新时，没有任何数据，系统也可以自动从$_POST中提取，如果还不清楚请参考HD框架手册',
    "model_replace_error" => '悲剧了。。。INSERT参数不能为空！',
    "model_token_error"=>"表单Token(令牌)错误",
    //HDPHP/Lib/usr/Model/Driver/relationModel.Class.php
    "relationmodel_check_error0" => "关联模型定义错误，请查看后盾HD框架手册学习",
    "relationmodel_check_error1" => '多表操作定义的表的模型属性type值没有定义，如果不清楚使用规范，请参数HD框架帮助手册',
    "relationmodel_check_error2" => '多表操作定义的表的模型属性type值必须是HAS_ONE、HAS_MANY、BELONGS_TO、MANY_TO_MANY中的一个，不区分大小写，如果不清楚使用规范，请参数HD框架帮助手册',
    "relationmodel_check_error3" => '使用多表操作MANY_TO_MANY的表没有定义relation_table属性即中间关联表，如果不清楚使用规范，请参数HD框架帮助手册',
    "relationmodel_check_error4" => '使用多表操作MANY_TO_MANY的表没有定义relation_table_parent_key属性，如果不清楚使用规范，请参数HD框架帮助手册',
    "relationmodel_check_error5" => '使用多表操作MANY_TO_MANY的表没有定义relation_table_foreign_key属性，如果不清楚使用规范，请参数HD框架帮助手册',
    "relationmodel_get_parent_key" => '表的主键不存在，手动设置主表的主键或都指定模型的parent_key值试试，还不行就看手册学习一下吧，很简单的！',
    "relationmodel_get_foreign_key1" => 'MANY_TO_MANY关联失败：2种解决方法，设置关联表的主键或都指定模型的foreign_key值',
    "relationmodel_get_foreign_key2" => '定义关联模型必须指定foreign_key值，如果不清楚使用规范，请参数HD框架帮助手册',
    "relationmodel_select" => '模型的parent_key属性定义错误,可能不存在此字段,或者主表结果集中不含parent_key字段',
    "relationmodel_insert" => '悲剧了。。。执行INSERT()时没有任何插入数据，插入数据可以是$_POST也可以直接传入INSERT()方法中，HD框架手册能帮到你！',
    "relationmodel_update" => '悲剧了。。。执行INSERT()时没有任何插入数据，插入数据可以是$_POST也可以直接传入INSERT()方法中，HD框架手册能帮到你！',
    //HDPHP/Lib/usr/Model/Driver/viewModel.Class.php
    "viewmodel_get_join_args1" => '定义视图必须指定ON值，如果不清楚使用规范，请参数HD框架帮助手册',
    "viewmodel_get_join_args2" => '视图模型定义type值定义错误，type必须为left, right, inner之一。可以不设置type值,不设置将使用inner，如果不清楚使用规范，请参数HD框架帮助手册',
    //HDPHP/Lib/usr/View/View.Class.php
    //"view_getTemplateFile_error1"=>'模板目录不能为空，请修改配置项TPL_DIR',
    "view_getTemplateFile_error2" => '模版文件扩展名不能为空，请修改配置项TPL_FIX',
    "view_getTemplateFile_error3" => '模版文件不存在',
    //HDPHP/Lib/usr/View/Hd/hdBaseTag.Class.php
    "hdbasetag__zoom" => 'zoom标签必须设置 big、small、data属性，检查一下看哪个没有设置',
    "hdbasetag__upload" => '上传标签upload必须指定name属性，如果不清楚使用规范请查看后盾HD框架手册',
    "hdbasetag__foreach1" => 'foreach 模板标签必须有from属性',
    "hdbasetag__foreach2" => 'foreach 模板标签必须有value属性',
    "hdbasetag__load" => 'load 模板标签必须有value属性',
    "hdbasetag__if" => 'if 模板标签必须有value属性',
    "hdbasetag__while" => 'while模板标签必须有value属性',
    "hdbasetag__empty" => 'empty模板标签必须有value属性',
    "hdbasetag__editor" => '必须设置编辑器的name属性,用于$_POST接收',
    "_TAG_PARAM_ERROR_"=>'标签参数错误',
    "_TAG_PARAM_ERROR_"=>'标签参数错误',
    "TAG_LIST_FROM_PARAM_ERROR"=>"list标签缺少from属性",
    "TAG_LIST_NAME_PARAM_ERROR"=>"list标签缺少name属性",
    //HDPHP/Lib/Core/debug/debug.Class.php
    "debug_show1" => '服务器信息',
    "debug_show2" => '客户端代理',
    "debug_show3" => 'PHP版本',
    "debug_show4" => '主机名',
    "debug_show5" => '请求方式',
    "debug_show6" => '通信协议',
    "debug_show7" => '当前脚本',
    "debug_show8" => '会话ID',
    "debug_show9" => '模板编译文件',
    "debug_show14" => '脚本总执行时间',
    "debug_show15" => '内存峰值',
    "_nohavedebugstart"=>"没有设置调试开始点：",
    //HDPHP/Lib/Core/debug/exceptionHD.Class.php
    "exceptionhd_getexception1" => '错误信息',
    "exceptionhd_getexception2" => '文件',
    "exceptionhd_getexception3" => '行号',
    "exceptionhd_show" => '查看详细错误信息方法有两种： ① 查看网站日志文件  ② 开启调试模式',
    "exceptionhd_error1" => '错误信息',
    "exceptionhd_error2" => '文件',
    "exceptionhd_error3" => '行号',
    "exceptionhd_error4" => '错误信息',
    "exceptionhd_error5" => '文件',
    "exceptionhd_error6" => '行号',
    "exceptionhd_notice" => 'NOTICE',
    //HDPHP/Lib/Core/application.php
    "application_apprun1" => '控制器',
    "application_apprun2" => '中的方法',
    "application_apprun3" => '不存在',
    #http://localhost/hdcms/setup/index.php?m=delcache&temp=D:/wamp/www/hdcms/temp
    "application_apprun4" => '应用不存在',
    "application_apprun_createapp"=>'点击创建应用',
    //HDPHP/Lib/bin/cart.Class.php
    "cart_add_error" => '购物车ADD方法参数设置错误',
    "cart_update_error" => '购物车update方法参数错误，缺少sid或num值',
    "cart_del_error" => '购物车update方法参数错误，缺少sid值',
    //HDPHP/Lib/bin/page.Class.php
    "page_nowpage" => '第',
    "page_count1" => '共',
    "page_count2" => '页',
    "page_count3" => '条记录',
    "page_show_case1" => '总计',
    //HDPHP/Lib/bin/rbac.Class.php
    "rbac_rbac_user_login1" => '用户表设置错误，请在配置文件中添加用户表',
    "rbac_rbac_user_login2" => '用户不存在',
    "rbac_rbac_user_login3" => '密码输入错误',
    "rbac_rbac_user_login4" => '不属于任何组，没有访问权限',
    //HDPHP/Lib/bin/upload.Class.php
    "upload_upload_error" => '图片上传目录创建失败或不可写',
    "upload_save_error1" => '图片上传目录创建失败或不可写',
    "upload_save_error2" => '移动临时文件失败',
    "upload_format_error" => '没有任何文件上传',
    "upload_checkFile_error1" => '文件类型不允许',
    "upload_checkFile_error2" => '上传文件大于',
    "upload_checkFile_error3" => '非法文件',
    "upload_checkFile_image" => '上传内容不是一个合法图片',
    "upload_error_error1" => '上传文件超过PHP.INI配置文件允许的大小',
    "upload_error_error2" => '文件超过表单限制大小',
    "upload_error_error3" => '文件只上有部分上传',
    "upload_error_error4" => '没有上传文件',
    "upload_error_error5" => '没有上传临时文件夹',
    "upload_error_error6" => '写入临时文件夹出错',
    //HDPHP/Lib/bin/validate.Class.php
    "validate__maxlen1" => '表单',
    "validate__maxlen2" => '的值，必须为数字',
    "validate__maxlen3" => '验证规则的maxlen参数设置错误，必须为数字',
    "validate__minlen1" => '表单',
    "validate__minlen2" => '的值必须为数字',
    "validate__minlen3" => '验证规则的maxlen参数设置错误，必须为数字',
    //HDPHP/Data/Language/success.html
    "success_html_title" => '后盾网提示——操作成功',
    "success_html_hd_error_html_h2" => '操作成功!',
    "success_html_span1" => '秒钟后将进行',
    "success_html_span2" => '跳转',
    "success_html_span3" => '也可以',
    "success_html_span4" => '返回首页',
    //HDPHP/Data/Language/halt.html
    "error_html_title" => '后盾网提示——操作失败',
    "error_html_hd_error_html_h2" => '操作失败!',
    "error_html_span1" => '秒钟后将进行',
    "error_html_span2" => '跳转',
    "error_html_span3" => '也可以',
    "error_html_span4" => '返回首页',
    //url.Class.php
	//HDPHP.Class.php
	"__call_method_no_exists"=>"方法不存在",
);
?>