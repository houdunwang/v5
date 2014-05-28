<!DOCTYPE html>
<html>
<head>
    <title>修改资料</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <hdjs/>
    <jcrop/>
    <bootstrap/>
    <link rel="stylesheet" type="text/css" href="__CONTROL_TPL__/css/user.css?ver=1.0"/>
    <js file="__CONTROL_TPL__/js/cropFace.js"/>
    <script type="text/javascript" src="__CONTROL_TPL__/uploadify/jquery.uploadify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="__CONTROL_TPL__/uploadify/uploadify.css"/>
    <hdcms/>
</head>
<body>
<load file="__TPL__/Public/block/top_menu.php"/>
<article class="center-block main">
<!--左侧导航start-->
<load file="__TPL__/Public/block/left_menu.php"/>
<!--左侧导航end-->
<section class="edit-user">
    <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#edit-base" data-toggle="tab">基本信息</a></li>
            <li><a href="#edit-face" data-toggle="tab">修改头像</a></li>
            <li><a href="#edit-password" data-toggle="tab">修改密码</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="edit-base">
                <form id="form_message" action="{|U:'edit_message'}" method="post"
                      onsubmit="return hd_submit(this,'{|U:'edit'}')">
                    <table>
                        <tr>
                            <th>
                                <img src="{$hd.session.icon150}" class="face"/>
                            </th>
                            <td class="field" colspan="2">
                                <textarea name="signature" style="height: 100px;" placeholder="请输入个性签名">{$field.signature}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th>个性域名</th>
                            <td class="field">
                                __ROOT__?
                                <input type="text" name="domain" value="{$field.domain}"/>
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td class="field">
                                <input type="submit" class="btn btn-primary" value="确定"/>
                            </td>
                            <td>

                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="tab-pane" id="edit-face">

                    <div class="source-face">
                        <div style="position:relative;border:solid 1px #999;width: 250px;height: 250px;overflow: hidden;margin-bottom:10px;">
                            <!--上传头像按钮 Start-->
                            <script>
                                $(function () {
                                    $('#file_upload').uploadify({
                                        'swf': '__CONTROL_TPL__/uploadify/uploadify.swf',
                                        'uploader': '__CONTROL__&m=upload_face',
                                        'removeCompleted' : false,
                                        'buttonImage': '__CONTROL_TPL__/uploadify/select_face.png',
                                        'fileTypeExts' : '*.jpg; *.png',
                                        'multi'    : false,
                                        'fileSizeLimit' : '2MB',
                                        'width': 250,
                                        'height': 250,
                                        'removeCompleted':true,
                                        'formData': {'<?php echo session_name();?>': '<?php echo session_id();?>'},
                                        'onUploadSuccess': function (file, data, response) {
                                            eval('data=' + data);
                                            if (data.state == 1) {
                                                var img = data.message.url;
                                                $("#target").attr("src", img);
                                                $("div.jcrop-holder img").attr("src", img);
                                                $("#preview150").attr("src", img);
                                                $("#preview100").attr("src", img);
                                                $("#preview50").attr("src", img);
                                                $("input[name=img_face]").val(data.message.path);
                                                $("#buttons").show();
                                                $("#face_upload").hide();
                                                $("#SWFUpload_0_0").remove();
                                            } else {
                                                alert(data.message);
                                            }
                                        }
                                    });
                                });
                                //重新上传头像
                                function reset_upload(){
                                    $("#buttons").hide();
                                    $("#face_upload").show();
                                }
                            </script>
                            <div id="face_upload">
                                <input type="file" name="file_upload" id="file_upload"/>
                            </div>
                            <!--上传头像按钮 End-->
                            <img src="__CONTROL_TPL__/images/select_face.png" id="target" style="display: none"/>
                        </div>
                        <div id="buttons" style="display: none">
                            <form action="{|U:'set_face'}" method="post" onsubmit="return hd_submit(this,'{|U:'edit'}')">
                            <button class="btn btn-primary" type="submit">保存</button>
                            <button class="btn btn-default" onclick="reset_upload();" type="button">重新上传</button>
                                <input type="hidden" name="img_face" value=""/>
                                <input type="hidden" size="4" id="x1" name="x1" value="0"/>
                                <input type="hidden" size="4" id="y1" name="y1" value="0"/>
                                <input type="hidden" size="4" id="x2" name="x2" value="249"/>
                                <input type="hidden" size="4" id="y2" name="y2" value="249"/>
                                <input type="hidden" size="4" id="w" name="w" value="250"/>
                                <input type="hidden" size="4" id="h" name="h" value="250"/>
                            </form>
                        </div>
                    </div>
                    <div class="face-preview">
                        <h2>头像预览</h2>

                        <div class="help">
                            请注意中小尺寸的头像是否清晰
                        </div>

                        <div class="face">
                            <div style="width:150px;height:150px;overflow:hidden;">
                                <img src="{$hd.session.icon150}" id="preview150" alt="Preview">
                            </div>
                            <p>
                                头像尺寸150X150
                            </p>
                        </div>
                        <div class="face">
                            <div style="width:100px;height:100px;overflow:hidden;">
                                <img src="{$hd.session.icon100}" id="preview100" alt="Preview">
                            </div>
                            <p>
                                头像尺寸100X100
                            </p>
                        </div>
                        <div class="face">
                            <div style="width:50px;height:50px;overflow:hidden;">
                                <img src="{$hd.session.icon50}" id="preview50" alt="Preview">
                            </div>
                            <p>
                                头像尺寸50X50
                            </p>
                        </div>
                    </div>

            </div>
            <div class="tab-pane" id="edit-password">
                <form id="form_password" action="{|U:'edit_password'}" onsubmit="return hd_submit(this)">
                    <table>
                        <tr>
                            <th>当前密码</th>
                            <td class="field">
                                <input type="password" name="password"/>
                            </td>
                            <td class="w200">
                                <span id="hd_password"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>新密码</th>
                            <td class="field">
                                <input type="password" name="newpassword"/>
                            </td>
                            <td>
                                <span id="hd_newpassword"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>重复密码</th>
                            <td class="field">
                                <input type="password" name="passwordc"/>
                            </td>
                            <td>
                                <span id="hd_passwordc"></span>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td class="field">
                                <input type="submit" class="btn btn-primary" value="确定"/>
                            </td>
                            <td>

                            </td>
                        </tr>
                    </table>
                </form>
                <script>
                    $("#form_message").validate({
                        domain: {
                            rule: {
                                required: true,
                                regexp:/[a-z0-9]/i,
                                ajax: CONTROL + '&m=check_domain'
                            },
                            error: {
                                required: "不能为空",
                                regexp:'请输入数字或字母',
                                ajax: '个性域名已经使用'
                            },
                            success: '输入正确',
                            message:'只能为数字或字母'
                        }
                    });
                    $("#form_password").validate({
                        password: {
                            rule: {
                                required:true,
                                ajax: CONTROL + '&m=check_password'
                            },
                            error: {
                                required:'不能为空',
                                ajax: '原密码错误'
                            },
                            success: '输入正确'
                        },
                        newpassword: {
                            rule: {
                                required:true,
                            },
                            error: {
                                required:'不能为空',
                            },
                            success: '输入正确'
                        },
                        passwordc: {
                            rule: {
                                confirm: 'newpassword'
                            },
                            error: {
                                confirm: '两次密码不一致'
                            }
                        }
                    })
                </script>
            </div>
        </div>
    </div>
</section>
</article>
<load file="__TPL__/Public/block/footer.php"/>
</body>
</html>