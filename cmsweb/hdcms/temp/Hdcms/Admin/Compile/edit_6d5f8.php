<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>修改栏目</title>
    <script type='text/javascript' src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend/Org/Jquery/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/cmsweb/hdcms';
		WEB = 'http://localhost/v5/cmsweb/hdcms/index.php';
		URL = 'http://localhost/v5/cmsweb/hdcms/a=Admin&c=Category&m=edit&cid=13';
		HDPHP = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp';
		HDPHPDATA = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend';
		APP = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin';
		CONTROL = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=Category';
		METH = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=Category&m=edit';
		GROUP = 'http://localhost/v5/cmsweb/hdcms/hd';
		TPL = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl';
		CONTROLTPL = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/Category';
		STATIC = 'http://localhost/v5/cmsweb/hdcms/Static';
		PUBLIC = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/Public';
		HISTORY = 'http://localhost/v5/cmsweb/hdcms/a=Admin&c=Category&m=index';
		HTTPREFERER = 'http://localhost/v5/cmsweb/hdcms/a=Admin&c=Category&m=index';
		TEMPLATE = 'http://localhost/v5/cmsweb/hdcms/template/default';
		ROOTURL = 'http://localhost/v5/cmsweb/hdcms';
		WEBURL = 'http://localhost/v5/cmsweb/hdcms/index.php';
		CONTROLURL = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=Category';
</script>
    <script type="text/javascript" src="http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/Category/js/addEdit.js"></script>
</head>
<body>
<form action="<?php echo U(edit);?>" method="post" class="hd-form" onsubmit="return hd_submit(this,'<?php echo U(index);?>')">
    <input type="hidden" value="<?php echo $field['cid'];?>" name="cid"/>
    <div class="wrap">
        <div class="menu_list">
            <ul>
                <li><a href="<?php echo U('index');?>">栏目列表</a></li>
                <li><a href="javascript:;" class="action">修改栏目</a></li>
                <li><a href="javascript:hd_ajax('<?php echo U(updateCache);?>')">更新栏目缓存</a></li>
            </ul>
        </div>
        <input type="hidden" name="mid" value="<?php echo $field['mid'];?>"/>
        <div class="tab">
            <ul class="tab_menu">
                <li lab="base"><a href="#">基本设置</a></li>
                <li lab="tpl"><a href="#">模板设置</a></li>
                <li lab="html"><a href="#">静态HTML设置</a></li>
                <li lab="seo"><a href="#">SEO</a></li>
                <li lab="access"><a href="#">权限设置</a></li>
                <li lab="charge"><a href="#">收费设置</a></li>
            </ul>
            <div class="tab_content">
                <div id="base">
                    <table class="table1">
                        <tr>
                            <th class="w100">上级</th>
                            <td>
                                <select name="pid">
                                    <option value="0">一级栏目</option>
                                    <?php $hd["list"]["c"]["total"]=0;if(isset($category) && !empty($category)):$_id_c=0;$_index_c=0;$lastc=min(1000,count($category));
$hd["list"]["c"]["first"]=true;
$hd["list"]["c"]["last"]=false;
$_total_c=ceil($lastc/1);$hd["list"]["c"]["total"]=$_total_c;
$_data_c = array_slice($category,0,$lastc);
if(count($_data_c)==0):echo "";
else:
foreach($_data_c as $key=>$c):
if(($_id_c)%1==0):$_id_c++;else:$_id_c++;continue;endif;
$hd["list"]["c"]["index"]=++$_index_c;
if($_index_c>=$_total_c):$hd["list"]["c"]["last"]=true;endif;?>

                                        <option value="<?php echo $c['cid'];?>"
                                        <?php echo $c['selected'];?> <?php echo $c['disabled'];?>>
                                        <?php echo $c['_name'];?>
                                        </option>
                                    <?php $hd["list"]["c"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>栏目名称</th>
                            <td>
                                <input type="text" name="catname" value="<?php echo $field['catname'];?>" class="w300" required=""/>
                            </td>
                        </tr>
                        <tr>
                            <th>栏目类型</th>
                            <td>
                                <label>
                                    <input type="radio" name="cattype" value="1" <?php if($field['cattype']==1){?>checked="checked"<?php }?>/> 普通栏目
                                </label>
                                <label>
                                    <input type="radio" name="cattype" value="2" <?php if($field['cattype']==2){?>checked="checked"<?php }?>/> 频道封面
                                </label>
                                <label>
                                    <input type="radio" name="cattype" value="3" <?php if($field['cattype']==3){?>checked="checked"<?php }?>/> 外部链接(在跳转Url处填写网址)
                                </label>
                                <label><input type="radio" name="cattype" value="4" <?php if($field['cattype']==4){?>checked="checked"<?php }?>/>单页面(直接发布文章，如:公司简介)</label>
                            </td>
                        </tr>
                        <tr>
                            <th>静态目录</th>
                            <td>
                                <input type="text" name="catdir" value="<?php echo $field['catdir'];?>" class="w300" required=""/>
                            </td>
                        </tr>
                        <tr>
                            <th>跳转Url</th>
                            <td>
                                <input type="text" name="cat_redirecturl" value="<?php echo $field['cat_redirecturl'];?>" class="w300"/>
                            </td>
                        </tr>
                        <tr>
                            <th>栏目访问</th>
                            <td>
                                <label>
                                    <input type="radio" name="cat_url_type" value="1" <?php if($field['cat_url_type']==1){?>checked="checked"<?php }?>/> 静态
                                </label>
                                <label>
                                    <input type="radio" name="cat_url_type" value="2" <?php if($field['cat_url_type']==2){?>checked="checked"<?php }?>/> 动态
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th>文章访问</th>
                            <td>
                                <label>
                                    <input type="radio" name="arc_url_type" value="1" <?php if($field['arc_url_type']==1){?>checked="checked"<?php }?>/> 静态
                                </label>
                                <label>
                                    <input type="radio" name="arc_url_type" value="2" <?php if($field['arc_url_type']==2){?>checked="checked"<?php }?>/> 动态
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th>在导航显示</th>
                            <td>
                                <label>
                                    <input type="radio" name="cat_show" value="1" <?php if($field['cat_show']==1){?>checked="checked"<?php }?>/> 是
                                </label>
                                <label>
                                    <input type="radio" name="cat_show" value="0" <?php if($field['cat_show']==0){?>checked="checked"<?php }?>/> 否
                                </label>
                                <span class="validate-message">前台使用&lt;channel&gt;标签时是否显示</span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="tpl" class="con">
                    <table class="table1">
                        <tr>
                            <th class="w100">封面模板</th>
                            <td>
                                <input type="text" name="index_tpl" required="" class="w200" id="index_tpl" value="<?php echo $field['index_tpl'];?>"
                                       onclick="select_template('index_tpl')" readonly="" onfocus="select_template('index_tpl');"/>
                                <button type="button" class="hd-cancel" onclick="select_template('index_tpl')">选择首页模板</button>
                                <span id="hd_index_tpl"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>列表页模板</th>
                            <td>
                                <input type="text" name="list_tpl" required="" id="list_tpl" class="w200" value="<?php echo $field['list_tpl'];?>"
                                       onclick="select_template('list_tpl')" readonly="" onfocus="select_template('list_tpl');"/>
                                <button type="button" class="hd-cancel" onclick="select_template('list_tpl')">选择列表模板</button>
                                <span id="hd_list_tpl"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>内容页模板</th>
                            <td>
                                <input type="text" name="arc_tpl" required="" id="arc_tpl" class="w200" value="<?php echo $field['arc_tpl'];?>"
                                       onclick="select_template('arc_tpl')" readonly="" onfocus="select_template('arc_tpl');"/>
                                <button type="button" class="hd-cancel" onclick="select_template('arc_tpl')">选择内容页模板</button>
                                <span id="hd_arc_tpl"></span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="html" class="con">
                    <table class="table1">
                        <tr>
                            <th class="w100">栏目页URL规则</th>
                            <td>
                                <input type="text" name="cat_html_url" required="" class="w300" value="<?php echo $field['cat_html_url'];?>"/>
                                <span id="hd_cat_html_url"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>内容页URL规则</th>
                            <td>
                                <input type="text" name="arc_html_url" required="" class="w300" value="<?php echo $field['arc_html_url'];?>"/>
                                <span id="hd_arc_html_url"></span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="seo">
                    <table class="table1">
                        <tr>
                            <th>关键字</th>
                            <td>
                                <input type="text" name="cat_keyworks" value="<?php echo $field['cat_keyworks'];?>" class="w350"/>
                            </td>
                        </tr>
                        <tr>
                            <th>描述</th>
                            <td>
                                <textarea name="cat_description" class="w350 h100"><?php echo $field['cat_description'];?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th class="w100">SEO标题</th>
                            <td>
                                <input type="text" name="cat_seo_title" value="<?php echo $field['cat_seo_title'];?>" class="w350"/>
                            </td>
                        </tr>
                        <tr>
                            <th>SEO描述</th>
                            <td>
                                <textarea name="cat_seo_description" class="w400 h150"><?php echo $field['cat_seo_description'];?></textarea>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="access">
                    <table class="table1">
                        <tr>
                            <th class="w100">
                                投稿不需要审核
                            </th>
                            <td>
                                <label><input type="radio" name="member_send_state" value="1" <?php if($field['member_send_state'] == 1){?>checked=""<?php }?>/> 是 </label>
                                <label><input type="radio" name="member_send_state" value="0" <?php if($field['member_send_state'] == 0){?>checked=""<?php }?>/> 否 </label>
                            </td>
                        </tr>
                    </table>
                    <table class="table1">
                        <tr>
                            <th class="w100">
                                管理组权限
                            </th>
                            <td>
                                <table class="table2">
                                    <thead>
                                    <tr>
                                        <td class="w250">组名</td>
                                        <td>查看</td>
                                        <td>添加</td>
                                        <td>修改</td>
                                        <td>删除</td>
                                        <td>排序</td>
                                        <td>移动</td>
                                        <td>审核</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $hd["list"]["r"]["total"]=0;if(isset($access['admin']) && !empty($access['admin'])):$_id_r=0;$_index_r=0;$lastr=min(1000,count($access['admin']));
$hd["list"]["r"]["first"]=true;
$hd["list"]["r"]["last"]=false;
$_total_r=ceil($lastr/1);$hd["list"]["r"]["total"]=$_total_r;
$_data_r = array_slice($access['admin'],0,$lastr);
if(count($_data_r)==0):echo "";
else:
foreach($_data_r as $key=>$r):
if(($_id_r)%1==0):$_id_r++;else:$_id_r++;continue;endif;
$hd["list"]["r"]["index"]=++$_index_r;
if($_index_r>=$_total_r):$hd["list"]["r"]["last"]=true;endif;?>

                                        <tr>
                                            <td>
                                                <a href="javascript:" onclick="select_access_checkbox(this)"><?php echo $r['rname'];?></a>
                                                <input type="hidden" name="access[<?php echo $r['rid'];?>][rid]" value="<?php echo $r['rid'];?>"/>
                                                <input type="hidden" name="access[<?php echo $r['rid'];?>][admin]" value="1"/>
                                            </td>
                                            <td><input type="checkbox" name="access[<?php echo $r['rid'];?>][show]" value="1" <?php if($r['show']){?>checked=""<?php }?>/></td>
                                            <td><input type="checkbox" name="access[<?php echo $r['rid'];?>][add]" value="1" <?php if($r['add']){?>checked=""<?php }?>/></td>
                                            <td><input type="checkbox" name="access[<?php echo $r['rid'];?>][edit]" value="1" <?php if($r['edit']){?>checked=""<?php }?>/></td>
                                            <td><input type="checkbox" name="access[<?php echo $r['rid'];?>][del]" value="1" <?php if($r['del']){?>checked=""<?php }?>/></td>
                                            <td><input type="checkbox" name="access[<?php echo $r['rid'];?>][order]" value="1" <?php if($r['order']){?>checked=""<?php }?>/></td>
                                            <td><input type="checkbox" name="access[<?php echo $r['rid'];?>][move]" value="1" <?php if($r['move']){?>checked=""<?php }?>/></td>
                                            <td><input type="checkbox" name="access[<?php echo $r['rid'];?>][audit]" value="1" <?php if($r['audit']){?>checked=""<?php }?>/></td>
                                        </tr>
                                    <?php $hd["list"]["r"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <th class="w100">
                                会员组权限
                            </th>
                            <td>
                                <table class="table2">
                                    <thead>
                                    <tr>
	                                    <td class="w250">组名</td>
	                                    <td>查看</td>
	                                    <td>投稿</td>
	                                    <td>修改</td>
	                                    <td>删除</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $hd["list"]["r"]["total"]=0;if(isset($access['user']) && !empty($access['user'])):$_id_r=0;$_index_r=0;$lastr=min(1000,count($access['user']));
$hd["list"]["r"]["first"]=true;
$hd["list"]["r"]["last"]=false;
$_total_r=ceil($lastr/1);$hd["list"]["r"]["total"]=$_total_r;
$_data_r = array_slice($access['user'],0,$lastr);
if(count($_data_r)==0):echo "";
else:
foreach($_data_r as $key=>$r):
if(($_id_r)%1==0):$_id_r++;else:$_id_r++;continue;endif;
$hd["list"]["r"]["index"]=++$_index_r;
if($_index_r>=$_total_r):$hd["list"]["r"]["last"]=true;endif;?>

                                        <tr>
                                            <td>
                                                <a href="javascript:" onclick="select_access_checkbox(this)"><?php echo $r['rname'];?></a>
                                                <input type="hidden" name="access[<?php echo $r['rid'];?>][rid]" value="<?php echo $r['rid'];?>"/>
                                                <input type="hidden" name="access[<?php echo $r['rid'];?>][admin]" value="0"/>
                                            </td>
                                            <td>
                                                <input type="checkbox" name="access[<?php echo $r['rid'];?>][show]" value="1" <?php if($r['show']){?>checked=""<?php }?>/>
                                            </td>
                                            <td>
                                                <input type="checkbox" name="access[<?php echo $r['rid'];?>][add]" value="1" <?php if($r['add']){?>checked=""<?php }?>/>
                                            </td>
                                            <td>
                                                <input type="checkbox" name="access[<?php echo $r['rid'];?>][edit]" value="1" <?php if($r['edit']){?>checked=""<?php }?>/>
                                            </td>
                                            <td>
                                                <input type="checkbox" name="access[<?php echo $r['rid'];?>][del]" value="1" <?php if($r['del']){?>checked=""<?php }?>/>
                                            </td>
                                        </tr>
                                    <?php $hd["list"]["r"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="charge">
                    <table class="table1">
                        <tr>
                            <th class="w100">会员设置阅读金币</th>
                            <td>
                                <label><input type="radio" name="allow_user_set_credits" value="1" <?php if($field['allow_user_set_credits'] == 1){?>checked=""<?php }?>/> 允许</label>
                                <label><input type="radio" name="allow_user_set_credits" value="0" <?php if($field['allow_user_set_credits'] == 0){?>checked=""<?php }?>/> 不允许</label>
                                <span class="validate-message">
                                    是否允许会员投稿时设置阅读金币 （只对前台投稿有效）
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="w100">投稿奖励</th>
                            <td>
                                <input type="text" name="add_reward" required="" class="w100" value="<?php echo $field['add_reward'];?>"/> 金币
                                <span id="hd_add_reward"></span>
                            </td>
                        </tr>
                        <tr>
                            <th class="w100">阅读金币</th>
                            <td>
                                <input type="text" name="show_credits" required="" class="w100" value="<?php echo $field['show_credits'];?>"/> 金币
                                <span id="hd_show_credits"></span>
                            </td>
                        </tr>
                        <tr>
                            <th class="w100">重复收费设置</th>
                            <td>
                                <input type="text" name="repeat_charge_day" required="" class="w100" value="<?php echo $field['repeat_charge_day'];?>"/> 天
                                <span id='hd_repeat_charge_day'>

                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="position-bottom">
        <input type="submit" class="hd-success" value="确定"/>
        <input type="button" class="hd-cancel" value="取消" onclick="location.href='http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=Category'"/>
    </div>
</form>
</body>
</html>