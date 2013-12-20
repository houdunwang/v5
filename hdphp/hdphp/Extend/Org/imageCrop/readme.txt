1. 使用时需要引入文件
   jquery.js
   crop.css
   crop.js
2. 在需要使用的地方粘贴以下布局

	<div id="imageCrop">
		<input name="x1" id="x1" type="hidden" value=""/>
		<input name="y1" id="y1" type="hidden" value=""/>
		<input name="x2" id="x2" type="hidden" value=""/>
		<input name="y2" id="y2" type="hidden" value=""/>
		<div class='init_bj'></div>
		<div class='loading'> </div>
		<div class='adorn'>
			<div id="sorce" class='sorce'>
				<div class='img'>
					<div> </div>
					<img src="1.jpg"/>
				</div>
				<div class="mark" id="mark">
					<div  class='size_view'></div>
					<div id="wireframe" class='wireframe'>
						<a id="dot1" class='dot' href="javascript:void(0)"></a>
						<a id="dot2" class='dot' href="javascript:void(0)"></a>
						<a id="dot3" class='dot' href="javascript:void(0)"></a>
						<a id="dot4" class='dot' href="javascript:void(0)"></a>
						<a id="dot5" class='dot' href="javascript:void(0)"></a>
						<a id="dot6" class='dot' href="javascript:void(0)"></a>
						<a id="dot7" class='dot' href="javascript:void(0)"></a>
						<a id="dot8" class='dot' href="javascript:void(0)"></a>
					</div>
					<img class='img' style="" src="1.jpg"/>
				</div>
			</div>
		</div>
		<div class='cropList'>
			<span class='hd_title'>预览</span>
			<ul id="preview">
				
			</ul>
		</div>
	</div>
3. 调用方式
	$().initCrop(
		'1.jpg',		//图像路径
		{
			width:320,	//裁切区域显示宽度
			preview:'180,120,120,80,60,40'  //预览尺寸［width,height,...］
		}
	); 