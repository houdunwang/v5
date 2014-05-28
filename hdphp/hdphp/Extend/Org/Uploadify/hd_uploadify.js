//当前文件只能加载一次
hd_uploadify_js = true;
var hd_uploadify_options = {
//    removeTimeout   : 11//提示框消失时间
    // ,fileSizeLimit  : '1000KB'//文件上传大小单位KB
    // ,fileTypeExts   : '*.gif; *.jpg; *.png'//允许上传文件类型
    // ,formData       : {'someKey' : 'someValue', 'someOtherKey' : 1}//POST提交的数据
    // ,uploadLimit   : 3//上传文件数量
    swf: UPLOADIFY_URL + 'uploadify.swf',
    uploader: HDPHP_CONTROL + "&m=hd_uploadify"//上传处理php
    ,
    buttonImage: UPLOADIFY_URL + 'upload2.png'//按钮图片
    ,
    fileTypeDesc: 'Image Files'//文件选择框提示信息
    ,
    width: 75//按钮高度
    ,
    height: 21//按钮宽度
    ,
    success_msg: "正在上传..."//上传成功提示文字
    ,
    overrideEvents: ['onDialogOpen', 'onUploadError', 'onSelectError', 'onDialogClose']//覆盖系统默认事件
    ,
    onInit: function () {
        uploadify_obj = this;
    },
    onSWFReady: function () {//swfupload准备好
        //        this.queueData.uploadsSuccessful=this.settings.uploadsSuccessNums;
        //如果是编辑图片，修改图上传成功数量  第一次时为0，编辑时会具体成功上传图片数量
        this.queueData.uploadsSuccessful = HDPHP_UPLOAD_TOTAL;
        //修改全局环境量
        this.setStats({
            //successful_uploads:this.settings.uploadsSuccessNums
            successful_uploads: this.queueData.uploadsSuccessful
        })
        alter_upload_msg(this);
    },
    onUploadError: function (file, errorCode, errorMsg, errorString) {

    },
    onDialogClose: function (queueData) {//关闭窗口触发，文件数溢出
        if (queueData.filesErrored > 0) {
            var file_upload_limit = this.settings.file_upload_limit;//允许上传的文件数量
            var allowUploadNums = file_upload_limit - this.queueData.uploadsSuccessful;//还可以上传的文件数
            alert("上传文件过大或者类型不允许");
        }

    },
    onUploadSuccess: function (file, data, response) {
        //上传失败
        if (data.substr(0, 1) !== '{'){
            alert(data);
        }
        eval("data=" + data);
        var upload_file_id = this.settings.id;//表单id
        //上传失败时 成功上传的文件数量减1
        if (data.stat == 0) {
            this.queueData.uploadsSuccessful--;
            alert(data.msg);
            return;
        }
        //成功上传的文件数量
        this.setStats.successful_uploads = this.queueData.uploadsSuccessful;
        //第几个上传文件，会受全局变量HDPHP_UPLOAD_TOTAL的影响
        var _index = this.setStats.successful_uploads;
        //更改上传成功信息
        alter_upload_msg(this);
        data.url = data.isimage == 1 ? data.url : UPLOADIFY_URL + "default.png";
        var div = $("." + upload_file_id + "_files ul");
        var html = "";
        var input_type = this.settings.input_type;
        html += "<li input_type='"+input_type+"' class='upload_thumb' style='width:" + this.settings.thumb_width + "px;'><div class='delUploadFile'></div>";
        html += "<img src='" + data.url + "' path='" + data.path + "' width='" + this.settings.thumb_width + "' height='" + this.settings.thumb_height + "'/>";
        //显示alt文本框
        if (this.settings.showalt) {
             _value=data.name || '';
            html += "<div class='upload_title'>" +
                "<input style='padding:3px 0px;width:" + (this.settings.thumb_width) + "px' type='text' name='" + upload_file_id.substr(13) + "[" + _index + "][alt]' value='"+_value+"' onblur=\"if(this.value=='')this.value='"+_value+"'\" onfocus=\"this.value=''\"/>" +
                "</div>";
        }
        //如果表表字段id
        if(data.table_id){
            html +="<input type='hidden' name='table_id' value='"+data.table_id+"'/>";
        }
        html += "<input type='hidden' t='file'   name='" + upload_file_id.substr(13) + "[" + _index + "][path]' value='" + data.path + "'/>";
        //缩略图表单
        if (data.thumb.length > 0) {
            for (var i = 0, total = data.thumb.length; i < total; i++) {
                html += "<input type='hidden' t='file' name='" + upload_file_id.substr(13) + "[" + _index + "][thumb][]' value='" + data.thumb[i] + "'/>";
            }
        }
        html += "</li>";
        div.append(html);
        if (typeof(hd_upload) == 'function') {
            hd_upload(file, data, response);
        }
    }
};
//修改提示信息内容 | 返回true可以继续上传
function alter_upload_msg(obj) {
    var upload_file_id = obj.settings.id;
    var file_size_limit = obj.settings.file_size_limit;//文件大小
    var file_upload_limit = obj.settings.file_upload_limit;//允许上传的文件数量
    var uploadsSuccessful = obj.queueData.uploadsSuccessful;//已经上传文件数
    var allowUploadNums = file_upload_limit - obj.queueData.uploadsSuccessful;//还可以上传的文件数
    var msg_obj = $("." + upload_file_id + "_msg span");
    if (allowUploadNums > 0) {
        obj.setStats({
            buttonClass: "disableButton"
        });
        //改变按钮类
        msg_obj.html("你已经上传" + uploadsSuccessful + "个文件,还可以上传" + allowUploadNums+"个文件");
        $("#" + upload_file_id).uploadify('disable', false);//使按钮生效
        $("#" + upload_file_id + "-button").css({
            "background-position": "center top"
        });//改变按钮背景图位置
    } else {
        msg_obj.html("您已达到数量上限，若要继续上传，请删掉一些现有文件。");
        $("#" + upload_file_id + "-button").css({
            "background-position": "center bottom"
        });//改变按钮背景图位置
        $("#" + upload_file_id).uploadify('disable', true);//超过上传限制，使按钮失效
        return false;
    }
    return true;
}
//Ajax删除文件
$(".delUploadFile").live("click", function () {
    var imgDiv = $(this).parent();
    var path = $(this).next("img").attr("path");//服务器文件路径
    var upload_file_id = $(this).parents("div").eq(0).attr("input_file_id");//
    var upload = $("#" + upload_file_id).data('uploadify');//获得swf对象
    var delInputs = imgDiv.find("input[t]");//数据
    var delFiles = '';//要删除的文件
    $(delInputs).each(function (i) {
        delFiles += $(this).val() + "@@";
    })
    $.post(HDPHP_CONTROL + "&m=hd_uploadify_del", {
        file: delFiles
    }, function (data) {
        if (data == 1) {
            upload.setStats({
                successful_uploads: --upload.queueData.uploadsSuccessful
            });
            alter_upload_msg(upload);
            imgDiv.fadeOut(500, function () {
                $(this).remove();
            });
        } else {
            alert("文件删除失败");
        }
    })
    return false;
})
//加水印复选框
$("input#add_upload_water").live("click", function () {
    var w = $(this).attr("checked")=="checked"?1:0;
    $("#"+$(this).attr("uploadify_id")).uploadify('settings', 'formData', {water: w});
})