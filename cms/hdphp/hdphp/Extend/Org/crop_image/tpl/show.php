<?php if (!defined("HDPHP_PATH"))?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Basic Handler | Jcrop Demo</title>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />

    <script src="../Jquery/jquery-1.8.2.min.js"></script>
    <script src="<?php echo $url;?>/jcrop/js/jquery.Jcrop.js"></script>
    <script type="text/javascript">

        jQuery(function($){

            var jcrop_api;

            $('#target').Jcrop({
                onChange:   showCoords,
                onSelect:   showCoords,
                onRelease:  clearCoords
            },function(){
                jcrop_api = this;
            });

            $('#coords').on('change','input',function(e){
                var x1 = $('#x1').val(),
                    x2 = $('#x2').val(),
                    y1 = $('#y1').val(),
                    y2 = $('#y2').val();
                jcrop_api.setSelect([x1,y1,x2,y2]);
            });

        });

        // Simple event handler, called from onChange and onSelect
        // event handlers, as per the Jcrop invocation above
        function showCoords(c)
        {
            $('#x1').val(c.x);
            $('#y1').val(c.y);
            $('#x2').val(c.x2);
            $('#y2').val(c.y2);
            $('#w').val(c.w);
            $('#h').val(c.h);
        };

        function clearCoords()
        {
            $('#coords input').val('');
        };



    </script>
    <link rel="stylesheet" href="<?php echo $url;?>/jcrop/demos/demo_files/main.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $url;?>/jcrop/demos/demo_files/demos.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $url;?>/jcrop/css/jquery.Jcrop.css" type="text/css" />
    <style type="text/css">

    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="span12">
            <div class="jc-demo-box">
                <img src="<?php echo $url;?>/jcrop/demos/demo_files/sago.jpg" id="target" width="300"/>
                <form id="coords"
                      class="coords"
                      onsubmit="return false;"
                      action="http://example.com/post.php">

                    <div class="inline-labels">
                        <label>X1 <input type="text" size="4" id="x1" name="x1" /></label>
                        <label>Y1 <input type="text" size="4" id="y1" name="y1" /></label>
                        <label>X2 <input type="text" size="4" id="x2" name="x2" /></label>
                        <label>Y2 <input type="text" size="4" id="y2" name="y2" /></label>
                        <label>W <input type="text" size="4" id="w" name="w" /></label>
                        <label>H <input type="text" size="4" id="h" name="h" /></label>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>

