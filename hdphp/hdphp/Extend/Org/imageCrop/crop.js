/**
 *	@author 郑印 	
 *  @date 2013-12-06
 	@email zhengyin.name@gmail.com   
 */


/*****  初始信息相关变量   ******/
var sImgSrc = '';
var iZoomWidth = 0;
var iZoomHeight = 0;
var iInitScale = 0;
var aPreviewArr = [];
/*****  拖放过程相关变量  ******/ 




$.fn.extend({
	minW:10,					//线框最小宽度
	minH:10,					//线框最小高度
	initCrop:function(imgSrc,size){
		if(imgSrc == '') alert('图像地址为空!')
		//加载图像
		var oImg = new Image();
		oImg.src = imgSrc;
		oImg.onload=function(){
			$('#imageCrop .init_bj').hide();
			$('#imageCrop .loading').hide();
			//拆分参数
			var arr = size.preview.split(',');
			//组合尺存数据				
			var sizeArr =[];
			var tempArr = [];
			for(var i=0;i<arr.length;i++){
				//不是数字
				if(!Number(arr[i])){
					arr.shift(arr[i]);
					i--;
					continue;
				}
				if(i%2 && arr[i]!='' && arr[i-1]!=''){
					sizeArr.push({'w':arr[i-1],'h':arr[i]});
					tempArr.push(arr[i-1]);
				}
			}
			var iWidth = size.width;
			var iScale = iWidth/oImg.width;
			var iHeight = oImg.height*iScale;
			var iMaxPreviewWidth = Math.max.apply({},tempArr); //最大预览宽度
			var iZoomScale = sizeArr[0].h/sizeArr[0].w;
			//设置图像地址,宽高
			$('#imageCrop img').attr('src',imgSrc).css({
				width:iWidth,
				height:iHeight
			});
			//设置元素位置尺寸
			//缩放窗口
			$('#imageCrop .sorce').css({
				width:iWidth,
				height:iHeight
			});
			$('#mark').css({
				width:sizeArr[0].w,
				height:sizeArr[0].h
			})
			
			//预览窗口
			$('#imageCrop .cropList').css({
				width:iMaxPreviewWidth
			})
			$('#imageCrop').css({
				width:iWidth+iMaxPreviewWidth+50
			})
			/***  记录参数  ***/
			$().initArg = {
				w:oImg.width,		//原图宽度
				h:oImg.height,		//原图高度
				s:iScale			//缩放比例
			};
			
			$('#imageCrop')[0].scale = iScale;
			$('#imageCrop')[0].zoomScale = iZoomScale;
			//运行
			$().runCrop({
				src:imgSrc,
				previewArr:sizeArr,
				w:iWidth,
				h:iHeight
			});
		}
		//图像加载失败提示
		oImg.onerror=function(){
			$('#imageCrop .loading').hide();
			alert('图像'+imgSrc+'加载失败！');
		}
	},
	runCrop:function(arg){
		$().setInitSite();
		$().markDrag();
		$().dotDrag();
		$().createPreviewNode(arg);
	},
	//设置初始位置
	setInitSite:function(){
		$('#mark').css({
			left:Math.floor($('#sorce').width()-$('#mark').width())/2,
			top:Math.floor($('#sorce').height()-$('#mark').height())/2
		})
		$('#mark .img').css({
			left:-$('#mark')[0].offsetLeft,
			top:-$('#mark')[0].offsetTop
		})
		$().createPreview();
	},
	//点拖拽
	dotDrag:function(){
		var iMarkLeft = $('#mark')[0].offsetLeft;
		var iMarkTop = $('#mark')[0].offsetTop;
		var iSorceWidth = $('#sorce').width();
		var iSorceHeight = $('#sorce').height();
		var iMarkW = $().markW();
		var iMarkH = $().markH();
		var zoomScale = $('#imageCrop')[0].zoomScale;
		//点1
		drag($('#dot1')[0],{
			l:-iMarkLeft,
			t:-iMarkTop,
			r:iSorceWidth-iMarkLeft,
			b:iSorceHeight-iMarkTop
		},function(dotL,dotT){
			dotT = zoomScale*dotL;
			var l = iMarkLeft+dotL;
			var w = iMarkW-dotL;
			var t = iMarkTop+dotT;
			var h = iMarkH-dotT;
			$().wireframeResize(l,t,w,h);
		});
		//点2
		drag($('#dot2')[0],{
			l:$('#dot2')[0].offsetLeft,
			t:-iMarkTop,
			r:$('#dot2')[0].offsetLeft,
			b:iSorceHeight-iMarkTop
		},function(dotL,dotT){
			var dotL = Math.floor(dotT/zoomScale);
			var l = iMarkLeft+Math.floor(dotL/2);
			var w = iMarkW-dotL;
			var t = iMarkTop+dotT/2;
			var h = iMarkH-dotT;
			$().wireframeResize(l,t,w,h);
		});
		//点3
		drag($('#dot3')[0],{
			l:-iMarkLeft-iMarkW,
			t:-iMarkTop,
			r:iSorceWidth-iMarkLeft,
			b:iSorceHeight-iMarkTop
		},function(dotL,dotT){
			dotT = -zoomScale*(dotL-iMarkW);
			var l = iMarkLeft;
			var t = iMarkTop+dotT;
			var w = dotL;
			var h = iMarkH-dotT;
			$().wireframeResize(l,t,w,h);
		});
		//点4
		drag($('#dot4')[0],{
			l:-iMarkLeft-iMarkW,
			t:$('#dot4')[0].offsetTop,
			r:iSorceWidth-iMarkLeft,
			b:$('#dot4')[0].offsetTop
		},function(dotL,dotT){
			var dotT = Math.floor(zoomScale*(dotL-iMarkW));
			var l = iMarkLeft-(dotL-iMarkW)/2;
			var t = iMarkTop-dotT/2;
			var w = dotL;
			var h = iMarkH+dotT;
			$().wireframeResize(l,t,w,h);
		});
		//点5
		drag($('#dot5')[0],{
			l:-iMarkTop-iMarkH,
			t:0,
			r:iSorceWidth-iMarkLeft,
			b:iSorceHeight-iMarkTop
		},function(dotL,dotT){
			dotT = zoomScale*dotL;
			var l = iMarkLeft;
			var t = iMarkTop;
			var w = dotL;
			var h = dotT;
			$().wireframeResize(l,t,w,h);
		});
		//点6
		drag($('#dot6')[0],{
			l:$('#dot6')[0].offsetLeft,
			t:0,
			r:$('#dot6')[0].offsetLeft,
			b:iSorceHeight-iMarkTop
		},function(dotL,dotT){
			var dotL = Math.floor((dotT-iMarkH)/zoomScale);
			var w = iMarkW+dotL;
			var l = iMarkLeft-Math.floor(dotL/2);
			var t = iMarkTop-(dotT-iMarkH)/2;
			var h = dotT;
			$().wireframeResize(l,t,w,h);
		});
		//点7
		drag($('#dot7')[0],{
			l:-iMarkLeft,
			t:0,
			r:iSorceWidth-iMarkLeft,
			b:iSorceHeight-iMarkTop
		},function(dotL,dotT){
			dotT = -zoomScale*dotL+iMarkH;
			var l = iMarkLeft+dotL;
			var t = iMarkTop;
			var w = iMarkW-dotL;
			var h = dotT;
			$().wireframeResize(l,t,w,h);
		});
		//点8
		drag($('#dot8')[0],{
			l:-iMarkLeft,
			t:$('#dot8')[0].offsetTop,
			r:iSorceWidth-iMarkLeft,
			b:$('#dot8')[0].offsetTop
		},function(dotL,dotT){
			var dotT = -Math.floor(zoomScale*dotL);
			var l = iMarkLeft+dotL/2;
			var t = iMarkTop-dotT/2;
			var w = iMarkW-dotL;
			var h = iMarkH+dotT;
			$().wireframeResize(l,t,w,h);
		});
	},
	/**
	 * 线框尺寸改变相关
	 * ------
	 * 位置参数
	 * @param {Object} l  left
	 * @param {Object} t  top
	 * @param {Object} w  width
	 * @param {Object} h  height
	 */
	wireframeResize:function(l,t,w,h){
		
		//最小宽度,最小高度
		if(w<=this.minW || h<=this.minH){
			$().dotDrag();
			$().markDrag();
			return false;
		}
		
		$('#mark').css({
			left:l,
			top:t,
			width:w,
			height:h
		})
		$('#mark .img').css({
			left:-l,
			top:-t
		})
		$().dotDrag();
		$().markDrag();
		$().createPreview();
	},
	//线框拖拽
	markDrag:function(){
		drag($('#mark')[0],{
			l:0,
			t:0,
			r:$('#sorce')[0].offsetWidth-$('#mark')[0].offsetWidth,
			b:$('#sorce')[0].offsetHeight-$('#mark')[0].offsetHeight
		},function(l,t){
			var l = l;
			var t = t;
			$('#mark').css({
				left:l,
				top:t
			})
			$('#mark .img').css({
				left:-l,
				top:-t
			})
			$().dotDrag();
			$().createPreview();
		});
		
	},
	//创建预览节点
	createPreviewNode:function(arg){
		var sizeArr = arg.previewArr;
		var oPrevire = $('#preview');
		for(var i in sizeArr){
			var nodeStr = '<li>\
				<p class="size">'+sizeArr[i].w+'x'+sizeArr[i].h+'</p>\
				<div style="width:'+sizeArr[i].w+'px;height:'+sizeArr[i].h+'px;" class="preview">\
					<img style="position:absolute;" class="img" src="'+arg.src+'"/>\
				</div>\
			</li>';
			$('#imageCrop').append('<input type="hidden" name="img[]" value="'+sizeArr[i].w+','+sizeArr[i].h+'">')
			oPrevire.append(nodeStr);
		}
		$('#imageCrop .adorn').css({
			width:arg.w,
			height:arg.h,
			marginTop:Math.floor(($('#imageCrop')[0].offsetHeight-$('#sorce')[0].offsetHeight)/2)
		})
		$().createPreview();
	},
	//创建预览
	createPreview:function(){
		//创建尺寸预览
		$('#mark .size_view').html($().markW()+' x '+$().markH());
		//获取坐标
		var x1 = $().markL();
		var y1 = $().markT();
		var x2 = $().markL()+$().markW();
		var y2 = $().markT()+$().markH();
		//裁切图像
		$('#mark .img').css({
			clip:'rect('+y1+'px,'+x2+'px,'+y2+'px,'+x1+'px)'
		})
		
		$('#preview .preview').each(function(){
			var iScaleW = $().markW()/this.offsetWidth;
			var iScaleH = $().markH()/this.offsetHeight;
			var iSourceW = $('#sorce')[0].offsetWidth;
			var iSourceH = $('#sorce')[0].offsetHeight;
			$(this).find('.img').css({
				width:Math.floor(iSourceW/iScaleW),
				height:Math.floor(iSourceH/iScaleH),
				left:-x1/iScaleW,
				top:-y1/iScaleH
			});
		})
		//计算对应的原图坐标
		var s_x1 = Math.floor(x1/$('#imageCrop')[0].scale);
		var s_y1 = Math.floor(y1/$('#imageCrop')[0].scale);
		var s_x2 = Math.floor(x2/$('#imageCrop')[0].scale);
		var s_y2 = Math.floor(y2/$('#imageCrop')[0].scale);
	//	document.title = 'x1='+s_x1+'y1='+s_y1+'x2='+s_x2+'y2='+s_y2;
		$('#x1').val(s_x1);
		$('#y1').val(s_y1);
		$('#x2').val(s_x2);
		$('#y2').val(s_y2);
	},
	
	//辅助方法
	markW:function(){
		return $('#mark')[0].offsetWidth;
	},
	markH:function(){
		return $('#mark')[0].offsetHeight;
	},
	markL:function(){
		return $('#mark')[0].offsetLeft;
	},
	markT:function(){
		return $('#mark')[0].offsetTop;
	}
	
})



/**
 * 拖拽函数
 * @param obj		//对象
 * @param site		//位置限制
 * @param fn		//回调函数
 */
function drag(obj,site,fn){
	var dmW = document.documentElement.clientWidth || document.body.clientWidth  
	var dmH = document.documentElement.clientHeight || document.body.clientHeight
	var site = site || {};
	var adsorb = site.n || 0;
	var l = site.l || 0;
	var r = (site.r || site.r==0)?site.r:dmW - obj.offsetWidth;
	var t = site.t || 0;
	var b = (site.b || site.b==0)?site.b:dmH - obj.offsetHeight; 
	obj.onmousedown=function(ev){
		var oEvent = ev || event;
		var siteX = oEvent.clientX-obj.offsetLeft;
		var siteY = oEvent.clientY- obj.offsetTop;
		if(obj.setCapture){
			obj.onmousemove=move;
			obj.onmouseup=up;
			obj.setCapture();
		}else{
			document.onmousemove=move;
			document.onmouseup=up;
		}
		function move(ev){
			var oEvent = ev || event;
			var iLeft = oEvent.clientX - siteX;
			var iTop = oEvent.clientY - siteY;
			if(iLeft <=l+adsorb){
				iLeft=l;
			}
			if(iLeft >=r-adsorb){
				iLeft= r;
			}
			if(iTop<=t+adsorb){
				iTop =t;
			}
			if(iTop >=b-adsorb){
				iTop = b;
			}
			if(fn){
				fn(iLeft,iTop)
			}else{
				obj.style.left = iLeft + 'px';
				obj.style.top = iTop + 'px';
			}
		}
		function up(){
			this.onmousemove=null;
			this.onmouseup=null;
			if(obj.setCapture){
				obj.releaseCapture();
			}
			$('#mark')[0].disable=false;
		}
		if(oEvent.stopPropagation){
			oEvent.stopPropagation(); 
		}
		oEvent.cancelBubble=true; 
		return false;
	}
}