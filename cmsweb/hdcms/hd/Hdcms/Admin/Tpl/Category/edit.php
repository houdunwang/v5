<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>修改栏目</title>
    <hdjs/>
    <js file="__CONTROL_TPL__/js/addEdit.js"/>
</head>
<body>
<form action="{|U:edit}" method="post" class="hd-form" onsubmit="return hd_submit(this,'{|U:index}')">
    <input type="hidden" value="{$field.cid}" name="cid"/>
    <div class="wrap">
        <div class="menu_list">
            <ul>
                <li><a href="{|U:'index'}">栏目列表</a></li>
                <li><a href="javascript:;" class="action">修改栏目</a></li>
                <li><a href="javascript:hd_ajax('{|U:updateCache}')">更新栏目缓存</a></li>
            </ul>
        </div>
        <input type="hidden" name="mid" value="{$field.mid}"/>
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
                                    <list from="$category" name="c">
                                        <option value="{$c.cid}"
                                        {$c.selected} {$c.disabled}>
                                        {$c._name}
                                        </option>
                                    </list>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>栏目名称</th>
                            <td>
                                <input type="text" name="catname" value="{$field.catname}" class="w300" required=""/>
                            </td>
                        </tr>
                        <tr>
                            <th>栏目类型</th>
                            <td>
                                <label>
                                    <input type="radio" name="cattype" value="1" <if value="$field.cattype==1">checked="checked"</if>/> 普通栏目
                                </label>
                                <label>
                                    <input type="radio" name="cattype" value="2" <if value="$field.cattype==2">checked="checked"</if>/> 频道封面
                                </label>
                                <label>
                                    <input type="radio" name="cattype" value="3" <if value="$field.cattype==3">checked="checked"</if>/> 外部链接(在跳转Url处填写网址)
                                </label>
                                <label><input type="radio" name="cattype" value="4" <if value="$field.cattype==4">checked="checked"</if>/>单页面(直接发布文章，如:公司简介)</label>
                            </td>
                        </tr>
                        <tr>
                            <th>静态目录</th>
                            <td>
                                <input type="text" name="catdir" value="{$field.catdir}" class="w300" required=""/>
                            </td>
                        </tr>
                        <tr>
                            <th>跳转Url</th>
                            <td>
                                <input type="text" name="cat_redirecturl" value="{$field.cat_redirecturl}" class="w300"/>
                            </td>
                        </tr>
                        <tr>
                            <th>栏目访问</th>
                            <td>
                                <label>
                                    <input type="radio" name="cat_url_type" value="1" <if value="$field.cat_url_type==1">checked="checked"</if>/> 静态
                                </label>
                                <label>
                                    <input type="radio" name="cat_url_type" value="2" <if value="$field.cat_url_type==2">checked="checked"</if>/> 动态
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th>文章访问</th>
                            <td>
                                <label>
                                    <input type="radio" name="arc_url_type" value="1" <if value="$field.arc_url_type==1">checked="checked"</if>/> 静态
                                </label>
                                <label>
                                    <input type="radio" name="arc_url_type" value="2" <if value="$field.arc_url_type==2">checked="checked"</if>/> 动态
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th>在导航显示</th>
                            <td>
                                <label>
                                    <input type="radio" name="cat_show" value="1" <if value="$field.cat_show==1">checked="checked"</if>/> 是
                                </label>
                                <label>
                                    <input type="radio" name="cat_show" value="0" <if value="$field.cat_show==0">checked="checked"</if>/> 否
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
                                <input type="text" name="index_tpl" required="" class="w200" id="index_tpl" value="{$field.index_tpl}"
                                       onclick="select_template('index_tpl')" readonly="" onfocus="select_template('index_tpl');"/>
                                <button type="button" class="hd-cancel" onclick="select_template('index_tpl')">选择首页模板</button>
                                <span id="hd_index_tpl"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>列表页模板</th>
                            <td>
                                <input type="text" name="list_tpl" required="" id="list_tpl" class="w200" value="{$field.list_tpl}"
                                       onclick="select_template('list_tpl')" readonly="" onfocus="select_template('list_tpl');"/>
                                <button type="button" class="hd-cancel" onclick="select_template('list_tpl')">选择列表模板</button>
                                <span id="hd_list_tpl"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>内容页模板</th>
                            <td>
                                <input type="text" name="arc_tpl" required="" id="arc_tpl" class="w200" value="{$field.arc_tpl}"
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
                                <input type="text" name="cat_html_url" required="" class="w300" value="{$field.cat_html_url}"/>
                                <span id="hd_cat_html_url"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>内容页URL规则</th>
                            <td>
                                <input type="text" name="arc_html_url" required="" class="w300" value="{$field.arc_html_url}"/>
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
                                <input type="text" name="cat_keyworks" value="{$field.cat_keyworks}" class="w350"/>
                            </td>
                        </tr>
                        <tr>
                            <th>描述</th>
                            <td>
                                <textarea name="cat_description" class="w350 h100">{$field.cat_description}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th class="w100">SEO标题</th>
                            <td>
                                <input type="text" name="cat_seo_title" value="{$field.cat_seo_title}" class="w350"/>
                            </td>
                        </tr>
                        <tr>
                            <th>SEO描述</th>
                            <td>
                                <textarea name="cat_seo_description" class="w400 h150">{$field.cat_seo_description}</textarea>
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
                                <label><input type="radio" name="member_send_state" value="1" <if value="$field.member_send_state eq 1">checked=""</if>/> 是 </label>
                                <label><input type="radio" name="member_send_state" value="0" <if value="$field.member_send_state eq 0">checked=""</if>/> 否 </label>
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
                                    <list from="$access.admin" name="r">
                                        <tr>
                                            <td>
                                                <a href="javascript:" onclick="select_access_checkbox(this)">{$r.rname}</a>
                                                <input type="hidden" name="access[{$r.rid}][rid]" value="{$r.rid}"/>
                                                <input type="hidden" name="access[{$r.rid}][admin]" value="1"/>
                                            </td>
                                            <td><input type="checkbox" name="access[{$r.rid}][show]" value="1" <if value="$r.show">checked=""</if>/></td>
                                            <td><input type="checkbox" name="access[{$r.rid}][add]" value="1" <if value="$r.add">checked=""</if>/></td>
                                            <td><input type="checkbox" name="access[{$r.rid}][edit]" value="1" <if value="$r.edit">checked=""</if>/></td>
                                            <td><input type="checkbox" name="access[{$r.rid}][del]" value="1" <if value="$r.del">checked=""</if>/></td>
                                            <td><input type="checkbox" name="access[{$r.rid}][order]" value="1" <if value="$r.order">checked=""</if>/></td>
                                            <td><input type="checkbox" name="access[{$r.rid}][move]" value="1" <if value="$r.move">checked=""</if>/></td>
                                            <td><input type="checkbox" name="access[{$r.rid}][audit]" value="1" <if value="$r.audit">checked=""</if>/></td>
                                        </tr>
                                    </list>
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
                                    <list from="$access.user" name="r">
                                        <tr>
                                            <td>
                                                <a href="javascript:" onclick="select_access_checkbox(this)">{$r.rname}</a>
                                                <input type="hidden" name="access[{$r.rid}][rid]" value="{$r.rid}"/>
                                                <input type="hidden" name="access[{$r.rid}][admin]" value="0"/>
                                            </td>
                                            <td>
                                                <input type="checkbox" name="access[{$r.rid}][show]" value="1" <if value="$r.show">checked=""</if>/>
                                            </td>
                                            <td>
                                                <input type="checkbox" name="access[{$r.rid}][add]" value="1" <if value="$r.add">checked=""</if>/>
                                            </td>
                                            <td>
                                                <input type="checkbox" name="access[{$r.rid}][edit]" value="1" <if value="$r.edit">checked=""</if>/>
                                            </td>
                                            <td>
                                                <input type="checkbox" name="access[{$r.rid}][del]" value="1" <if value="$r.del">checked=""</if>/>
                                            </td>
                                        </tr>
                                    </list>
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
                                <label><input type="radio" name="allow_user_set_credits" value="1" <if value="$field.allow_user_set_credits eq 1">checked=""</if>/> 允许</label>
                                <label><input type="radio" name="allow_user_set_credits" value="0" <if value="$field.allow_user_set_credits eq 0">checked=""</if>/> 不允许</label>
                                <span class="validate-message">
                                    是否允许会员投稿时设置阅读金币 （只对前台投稿有效）
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="w100">投稿奖励</th>
                            <td>
                                <input type="text" name="add_reward" required="" class="w100" value="{$field.add_reward}"/> 金币
                                <span id="hd_add_reward"></span>
                            </td>
                        </tr>
                        <tr>
                            <th class="w100">阅读金币</th>
                            <td>
                                <input type="text" name="show_credits" required="" class="w100" value="{$field.show_credits}"/> 金币
                                <span id="hd_show_credits"></span>
                            </td>
                        </tr>
                        <tr>
                            <th class="w100">重复收费设置</th>
                            <td>
                                <input type="text" name="repeat_charge_day" required="" class="w100" value="{$field.repeat_charge_day}"/> 天
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
        <input type="button" class="hd-cancel" value="取消" onclick="location.href='__CONTROL__'"/>
    </div>
</form>
</body>
</html>