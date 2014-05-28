//裁切头像
jQuery(function($){
    var jcrop_api,boundx,boundy;
    $("#target").Jcrop({
        onChange:updatePreview,
        onSelect:updatePreview,
        aspectRatio:1
    },function(){
        var bounds=this.getBounds();
        boundx=bounds[0];
        boundy=bounds[1];
        jcrop_api=this;
    });
    function updatePreview(c){
        if(parseInt(c.w)>0){
            var rx0=150/c.w;
            var ry0=150/c.h;

            $("#preview150").css({
                width:Math.round(rx0*boundx)+"px",
                height:Math.round(ry0*boundy)+"px",
                marginLeft:"-"+Math.round(rx0*c.x)+"px",
                marginTop:"-"+Math.round(ry0*c.y)+"px"
            });

            var rx=100/c.w;
            var ry=100/c.h;
            $("#preview100").css({
                width:Math.round(rx*boundx)+"px",
                height:Math.round(ry*boundy)+"px",
                marginLeft:"-"+Math.round(rx*c.x)+"px",
                marginTop:"-"+Math.round(ry*c.y)+"px"
            });

            var rx1=50/c.w;
            var ry1=50/c.h;

            $("#preview50").css({
                width:Math.round(rx1*boundx)+"px",
                height:Math.round(ry1*boundy)+"px",
                marginLeft:"-"+Math.round(rx1*c.x)+"px",
                marginTop:"-"+Math.round(ry1*c.y)+"px"
            });
        };
        $("#x1").val(c.x);
        $("#y1").val(c.y);
        $("#x2").val(c.x2);
        $("#y2").val(c.y2);
        $("#w").val(c.w);
        $("#h").val(c.h);
    };
});