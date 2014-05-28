<?php

/**
 * 文章审核
 * Class ContentControl
 * @author 向军 <houdunwangxj@gmail.com>
 */
class ContentAuditControl extends AuthControl
{
    //栏目缓存
    private $_category;
    //模型缓存
    private $_model;
    //模型mid
    private $_mid;

    //构造函数
    public function __init()
    {
        $this->_model = cache("model", false);
        $this->_category = cache("category", false);
        $this->_mid = Q('mid', 1, 'intval');
        if (!isset($this->_model[$this->_mid])) {
            $this->error("模型不存在！");
        }
    }

    //文章列表
    public function content()
    {
    	$Model = ContentViewModel::getInstance($this->_mid);
        $count = $Model->where('content_state=0')->count();
        $page = new Page($count, 15);
        $data = $Model->where('content_state=0')->limit($page->limit())->order('updatetime DESC')->all();
		$this->assign('data',$data);
		$this->assign('mid',$this->_mid);
		$this->assign('model',$this->_model);
		$this->assign('page',$page->show());
        $this->display();
    }

    /**
     * 删除文章
     */
    public function del()
    {
        $aids = Q("request.aid");
        if (!empty($aids)) {
            if (!is_array($aids)) {
                $aids = array($aids);
            }
			$Model=new Content($this->_mid);
            foreach ($aids as $aid){
                $Model->del($aid);
            }
            $this->success( '删除成功');
        } else {
            $this->error('参数错误');
        }
    }

    /**
     * 审核或取消审核
     */
    public function audit()
    {
    	$Model = ContentViewModel::getInstance($this->_mid);
        //1 审核  0 取消审核
        $content_state = Q("content_state", 1, "intval");
        //文章id
        $aids = Q("post.aid");
        foreach ($aids as $aid) {
            $Model->save(array("aid" => $aid, "content_state" => $content_state));
        }
        $this->success('操作成功！');
    }
}


