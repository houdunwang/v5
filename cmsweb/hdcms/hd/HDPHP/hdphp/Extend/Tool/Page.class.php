<?php
// .-----------------------------------------------------------------------------------
// |  Software: [HDPHP framework]
// |   Version: 2013.01
// |      Site: http://www.hdphp.com
// |-----------------------------------------------------------------------------------
// |    Author: 向军 <houdunwangxj@gmail.com>
// | Copyright (c) 2012-2013, http://houdunwang.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------
// |   License: http://www.apache.org/licenses/LICENSE-2.0
// '-----------------------------------------------------------------------------------

/**
 * 分页处理类
 * @package     tools_class
 * @author      后盾向军 <houdunwangxj@gmail.com>
 * @editor      诚加宝重桦 <yuchonghua@163.com>
 */
class Page
{
    static $staticTotalPage = null; //总页数
    static $staticUrl = null; //当前url
    static $fix = ''; //静态后缀如.html
    static $pageNumLabel = '{page}'; //替换标签
    public $totalRow; //总条数
    public $totalPage; //总页数
    public $arcRow; //每页显示数
    public $pageRow; //每页显示页码数
    public $selfPage; //当前页
    public $url; //页面地址
    public $args; //页面传递参数
    public $startId; //当前页开始ID
    public $endId; //当前页末尾ID
    public $desc = array(); //文字描述

    /**
     * @param int $total 总条数
     * @param string $row 每页显示条数
     * @param string $pageRow 显示页码数量
     * @param string $desc 描述文字
     * @param string $setSelfPage 当前页
     * @param string $customUrl 自定义url地址
     * @param string $pageNumLabel 页码变量,默认为{page}
     */

    function __construct($total, $row = '', $pageRow = '', $desc = '',
                         $setSelfPage = '', $customUrl = '', $pageNumLabel = '{page}')
    {
        $this->totalRow = $total; //总条数
        $this->arcRow = empty($row) ? C("PAGE_SHOW_ROW") : $row; //每页显示条数
        $this->pageRow = (empty($pageRow) ? C('PAGE_ROW') : $pageRow) - 1; //显示页码数量
        $this->totalPage = ceil($this->totalRow / $this->arcRow); //总页数
        self::$staticTotalPage =$GLOBALS['totalPage']= $this->totalPage; //总页数
        self::$pageNumLabel = empty($pageNumLabel) ? self::$pageNumLabel : $pageNumLabel; //替换标签
        $this->selfPage = min($this->totalPage, empty($setSelfPage) ? empty($_GET[C("PAGE_VAR")]) ? 1 : max(1, (int)$_GET[C("PAGE_VAR")]) : max(1, (int)$setSelfPage)); //当前页
        $this->url = $this->setUrl($customUrl); //配置url地址
        $this->startId = ($this->selfPage - 1) * $this->arcRow + 1; //当前页开始ID
        $this->endId = min($this->selfPage * $this->arcRow, $this->totalRow); //当前页结束ID
        $this->desc = $this->desc($desc);
    }

    /**
     *
     * 配置描述文字
     * @param array $desc
     * <code>
     * "pre"=>"上一页"
     * "next"=>"下一页"
     * "pres"=>"前十页"
     * "nexts"=>"下十页"
     * "first"=>"首页"
     * "end"=>"尾页"
     * "unit"=>"条"
     * </code>
     * @return array
     */
    private function desc($desc)
    {
        $this->desc = array_change_key_case(C('PAGE_DESC'));
        if (empty($desc) || !is_array($desc))
            return $this->desc;

        function filter($v)
        {
            return !empty($v);
        }

        return array_merge($this->desc, array_filter($desc, "filter"));
    }

    //获取URL地址
    protected function getUrl($pageNum)
    {
        $returnUrl = $this->url;
        /**
         * 数型返回url地址
         * b(before)返回url地址前部分
         * a(after)返回url地址后部分
         */
        if (strtolower($pageNum) == 'b') {
            $returnUrl = substr($returnUrl, 0, strpos($returnUrl, self::$pageNumLabel));
        } elseif (strtolower($pageNum) == 'a') {
            $returnUrl = substr($returnUrl, strpos($returnUrl, self::$pageNumLabel) + strlen(self::$pageNumLabel));
        } else {
            $returnUrl = str_replace(self::$pageNumLabel, $pageNum, $returnUrl);
        }
        return self::$staticUrl?$returnUrl:U($returnUrl);
    }

    //配置URL地址
    protected function setUrl($customUrl)
    {
        if(!is_null(self::$staticUrl)){
            $returnUrl = self::$staticUrl . self::$fix; //配置url地址
        }else if (!empty($customUrl)) {
            if (strstr($customUrl, self::$pageNumLabel)) {
                $returnUrl = $customUrl;
            } else {
                switch (C("URL_TYPE")) {
                    case 1:
                        $returnUrl = $customUrl . '/' . C('PAGE_VAR') . '/' . self::$pageNumLabel . self::$fix;
                        break;
                    case 2:
                    default:
                        $returnUrl = $customUrl . '&' . C('PAGE_VAR') . '=' . self::$pageNumLabel . self::$fix;
                        break;
                }
            }
        } else{
            $get = $_GET;
            unset($get["a"]);
            unset($get['c']);
            unset($get["m"]);
            unset($get[C("PAGE_VAR")]);
            $url_type = C("URL_TYPE");
            switch ($url_type) {
                case 1:
                    $url = __METH__ . '/';
                    foreach ($get as $k => $v) {
                        $url .= $k . '/' . $v . '/';
                    }
                    $returnUrl = rtrim($url, '/') . '/' . C("PAGE_VAR") . '/' . self::$pageNumLabel . self::$fix;
                    break;
                case 2:
                default:
                    $url = __METH__ . '&';
                    foreach ($get as $k => $v) {
                        $url .= $k . "=" . $v . '&';
                    }
                    $returnUrl = $url . C("PAGE_VAR") . '=' . self::$pageNumLabel . self::$fix;
            }
        }
        return $returnUrl;
    }

    /**
     * SQL的limit语句
     * @param bool $stat true 返回字符串  false 返回数组
     * @return array|string
     */
    public function limit($stat = false)
    {
        if ($stat) {
            return max(0, ($this->selfPage - 1) * $this->arcRow) . "," . $this->arcRow;
        } else {
            return array("limit" => max(0, ($this->selfPage - 1) * $this->arcRow) . "," . $this->arcRow);
        }
    }

    //上一页
    protected function pre()
    {
        if ($this->selfPage > 1 && $this->selfPage <= $this->totalPage) {
            return "<a href='" . $this->getUrl($this->selfPage - 1) . "' class='pre'>{$this->desc['pre']}</a>";
        }
        return "<span class='close'>{$this->desc['pre']}</span>";
    }

    //下一页
    public function next()
    {
        $next = $this->desc ['next'];
        if ($this->selfPage < $this->totalPage) {
            return "<a href='" . $this->getUrl($this->selfPage + 1) . "' class='next'>{$next}</a>";
        }
        return "<span class='close'>{$next}</span>";
    }

    //列表项
    private function pageList()
    {
        //页码
        $pageList = '';
        $start = max(1, min($this->selfPage - ceil($this->pageRow / 2), $this->totalPage - $this->pageRow));
        $end = min($this->pageRow + $start, $this->totalPage);
        if ($end == 1) //只有一页不显示页码
            return '';
        for ($i = $start; $i <= $end; $i++) {
            if ($this->selfPage == $i) {
                $pageList [$i] ['url'] = "";
                $pageList [$i] ['str'] = $i;
                continue;
            }
            $pageList [$i] ['url'] = $this->getUrl($i);
            $pageList [$i] ['str'] = $i;
        }
        return $pageList;
    }

    //文字页码列表
    public function strList()
    {
        $arr = $this->pageList();
        $str = '';
        if (empty($arr))
            return "<strong class='selfpage'>1</strong>";
        foreach ($arr as $v) {
            $str .= empty($v ['url']) ? "<strong class='selfpage'>" . $v ['str'] . "</strong>" : "<a href={$v['url']}>{$v['str']}</a>";
        }
        return $str;
    }

    //图标页码列表
    public function picList()
    {
        $str = '';
        $first = $this->selfPage == 1 ? "" : "<a href='" . $this->getUrl(1) . "' class='picList'><span><<</span></a>";
        $end = $this->selfPage >= $this->totalPage ? "" : "<a href='" . $this->getUrl($this->totalPage) . "'  class='picList'><span>>></span></a>";
        $pre = $this->selfPage <= 1 ? "" : "<a href='" . $this->getUrl($this->selfPage - 1) . "'  class='picList'><span><</span></a>";
        $next = $this->selfPage >= $this->totalPage ? "" : "<a href='" . $this->getUrl($this->selfPage + 1) . "'  class='picList'><span>></span></a>";

        return $first . $pre . $next . $end;
    }

    //选项列表
    public function select()
    {
        $arr = $this->pageList();
        if (!$arr) {
            return '';
        }
        $str = "<select name='page' class='page_select' onchange='
		javascript:
		location.href=this.options[selectedIndex].value;'>";
        foreach ($arr as $v) {
            $str .= empty($v ['url']) ? "<option value='{$this->getUrl($v['str'])}' selected='selected'>{$v['str']}</option>" : "<option value='{$v['url']}'>{$v['str']}</option>";
        }
        return $str . "</select>";
    }

    //输入框
    public function input()
    {
        $str = "<input id='pagekeydown' type='text' name='page' value='{$this->selfPage}' class='pageinput' onkeydown = \"javascript:
					if(event.keyCode==13){
						location.href='{$this->getUrl('B')}'+this.value+'{$this->getUrl('A')}';
					}
				\"/>
				<button class='pagebt' onclick = \"javascript:
					var input = document.getElementById('pagekeydown');
					location.href='{$this->getUrl('B')}'+input.value+'{$this->getUrl('A')}';
				\">进入</button>
";
        return $str;
    }

    //前几页
    public function pres()
    {
        $num = max(1, $this->selfPage - $this->pageRow);
        return $this->selfPage > $this->pageRow ? "<a href='" . $this->getUrl($num) . "' class='pres'>前{$this->pageRow}页</a>" : "";
    }

    //后几页
    public function nexts()
    {
        $num = min($this->totalPage, $this->selfPage + $this->pageRow);
        return $this->selfPage + $this->pageRow < $this->totalPage ? "<a href='" . $this->getUrl($num) . "' class='nexts'>后{$this->pageRow}页</a>" : "";
    }

    //首页
    public function first()
    {
        $first = $this->desc ['first'];
        return $this->selfPage - $this->pageRow > 1 ? "<a href='" . $this->getUrl(1) . " class='first'>{$first}</a>" : "";
    }

    //末页
    public function end()
    {
        $end = $this->desc ['end'];
        return $this->selfPage < $this->totalPage - $this->pageRow ? "<a href='" . $this->getUrl($this->totalPage) . "' class='end'>{$end}</a>" : "";
    }

    //当前页记录
    public function nowPage()
    {
        return "<span class='nowPage'>第{$this->startId}-{$this->endId}{$this->desc['unit']}</span>";
    }

    //count统计
    public function count()
    {
        return "<span class='count'>[共{$this->totalPage}页] [{$this->totalRow}条记录]</span>";
    }

    /**
     * 返回所有分页信息
     * @return Array
     */
    public function getAll()
    {
        $show = array();
        $show['count'] = $this->count();
        $show['first'] = $this->first();
        $show['pre'] = $this->pre();
        $show['pres'] = $this->pres();
        $show['strList'] = $this->strList();
        $show['nexts'] = $this->nexts();
        $show['next'] = $this->next();
        $show['end'] = $this->end();
        $show['nowPage'] = $this->nowPage();
        $show['select'] = $this->select();
        $show['input'] = $this->input();
        $show['picList'] = $this->picList();
        return $show;
    }

    /**
     * 显示页码
     * @param string $style 风格
     * @param int $pageRow 页码显示行数
     * @return string
     */
    public function show($style = '', $pageRow = null)
    {
        if (empty($style)) {
            $style = C('PAGE_STYLE');
        }
        //页码显示行数
        $this->pageRow = is_null($pageRow) ? $this->pageRow : $pageRow - 1;
        switch ($style) {
            case 1 :
                return "{$this->count()}{$this->first()}{$this->pre()}{$this->pres()}{$this->strList()}{$this->nexts()}{$this->next()}{$this->end()}
                {$this->nowPage()}{$this->select()}{$this->input()}{$this->picList()}";
            case 2 :
                return $this->pre() . $this->strList() . $this->next() . $this->count();
            case 3 :
                return $this->pre() . $this->strList() . $this->next();
            case 4 :
                return "<span class='total'>总计:{$this->totalRow}
                {$this->desc['unit']}</span>" . $this->picList() . $this->select();
            case 5:
                return $this->first() . $this->pre() . $this->strList() . $this->next() . $this->end();
        }
    }

}