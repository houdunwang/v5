//预览图片
function view_image(obj) {
	var src = $(obj).attr('src');
	var viewImg = $('#view_img');
	//删除预览图
	if (viewImg.length >= 1) {
		viewImg.remove();
	}
	//鼠标移除时删除预览图
	$(obj).mouseout(function(){
		$('#view_img').remove();
	})
	if (src) {
		var offset = $(obj).offset();
		var _left = 100+offset.left+"px";
		var _top = offset.top-50+"px";
		var html = '<img src="' + src + '" style="border:solid 5px #dcdcdc;position:absolute;z-index:1000;width:300px;height:200px;left:'+_left+';top:'+_top+';" id="view_img"/>';
		$('body').append(html);
	}
}
