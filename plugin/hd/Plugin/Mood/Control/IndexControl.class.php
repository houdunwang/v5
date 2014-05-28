<?php
//测试控制器类
class IndexControl extends Control{
    function index(){
        $db = M("mood");
        $d = $db->where(array('mid'=>$_GET['mid'],'aid'=>$_GET['aid'],'mood_id'=>1))->count();
        $c = $db->where(array('mid'=>$_GET['mid'],'aid'=>$_GET['aid'],'mood_id'=>2))->count();
        $this->assign("d",$d);
        $this->assign('c',$c);
         $con =  $this->fetch();
        echo "document.write('<div id=\"hdmood\">" . preg_replace('@\r|\n@mi', '', addslashes($con)) . "</div>')";
        exit;
      
    }
    public function add(){
    	 if(!session('uid')){
    	 	$this->ajax(array('status'=>0,'message'=>"请先登录!"));
    	 }else{
    	 	$db = M('mood');
    	 	$state = $db->where(array('mid'=>$_POST['mid'],'aid'=>$_POST['aid'],'uid'=>$_SESSION['uid']))->find();
    	 	if($state){
    	 		$this->ajax(array('status'=>0,'message'=>'不允许重复操作'));
    	 	}else{
	    	 	$data=$_POST;
	    	 	$data['uid']=session('uid');
	    	 	$db->add($data);
	    	 	$this->ajax(array('status'=>1,'message'=>'操作成功'));
    	 	}
    	 }
    }
}
?>