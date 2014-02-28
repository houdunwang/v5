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
 * 购物车类
 * @package     tools_class
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
final class Cart
{

    /**
     * SESSION购物车中的名称
     * @var string
     */
    static public $cartName = 'cart'; //购物车名

    /**
     * 添加购物车
     * @access  public
     * @param array $data
     * <code>
     * $data为数组包含以下几个值
     * $Data=array(
     *  "id"=>1,                        //商品ID
     *  "name"=>"后盾网2周年西服",         //商品名称
     *  "num"=>2,                       //商品数量
     *  "price"=>188.88,                //商品价格
     *  "options"=>array(               //其他参数，如价格、颜色可以是数组或字符串|可以不添加
     *      "color"=>"red",
     *      "size"=>"L"
     *  )
     * </code>
     * @return void
     */

    static function add($data)
    {
        if (!is_array($data) || !isset($data['id']) || !isset($data['name']) || !isset($data['num']) || !isset($data['price'])) {
            throw_exception('购物车ADD方法参数设置错误');
        }
        $data = isset($data[0]) ? $data : array($data);
        $goods = self::getGoods(); //获得商品数据
        //添加商品增持多商品添加
        foreach ($data as $v) {
            $options = isset($v['options']) ? $v['options'] : '';
            $sid = substr(md5($v['id'] . serialize($options)), 0, 8); //生成维一ID用于处理相同商品有不同属性时
            if (isset($goods[$sid])) {
                if ($v['num'] == 0) { //如果数量为0删除商品
                    unset($goods[$sid]);
                    continue;
                }
                //已经存在相同商品时增加商品数量
                $goods[$sid]['num'] = $goods[$sid]['num'] + $v['num'];
                $goods[$sid]['total'] = $goods[$sid]['num'] * $goods[$sid]['price'];
            } else {
                if ($v['num'] == 0)
                    continue;
                $goods[$sid] = $v;
                $goods[$sid]['total'] = $v['num'] * $v['price'];
            }
        }

        self::save($goods);
    }

    static private function save($goods)
    {
        $_SESSION[self::$cartName]['goods'] = $goods;
        $_SESSION[self::$cartName]['total_rows'] = self::getTotalNums();
        $_SESSION[self::$cartName]['total'] = self::getTotalPrice();
    }

    /**
     * 更新购物车
     * @param array $data
     * $data为数组包含以下几个值
     * $Data=array(
     *  "sid"=>1,                        //商品的唯一SID，不是商品的ID
     *  "num"=>2,                       //商品数量
     */
    static function update($data)
    {
        $goods = self::getGoods(); //获得商品数据
        if (!isset($data['sid']) || !isset($data['num'])) {
            halt('购物车update方法参数错误，缺少sid或num值');
        }
        $data = isset($data[0]) ? $data : array($data); //允许一次删除多个商品
        foreach ($data as $dataOne) {
            foreach ($goods as $k => $v) {
                if ($k == $dataOne['sid']) {
                    if ($dataOne['num'] == 0) {
                        unset($goods[$k]);
                        continue;
                    }
                    $goods[$k]['num'] = $dataOne['num'];
                }
            }
        }
        self::save($goods);
    }

    /**
     * 统计购物车中商品数量
     */
    static function getTotalNums()
    {
        $goods = self::getGoods(); //获得商品数据
        $rows = 0;
        foreach ($goods as $v) {
            $rows += $v['num'];
        }
        return $rows;
    }

    /**
     * 获得商品汇总价格
     */
    static function getTotalPrice()
    {
        $goods = self::getGoods(); //获得商品数据
        $total = 0;
        foreach ($goods as $v) {
            $total += $v['price'] * $v['num'];
        }
        return $total;
    }

    /**
     * 删除购物车
     * 必须传递商品的sid值
     * @param $data
     * @return bool
     */
    static function del($data)
    {
        $goods = self::getGoods(); //获得商品数据
        if (empty($goods)) {
            return false;
        }
        $sid = array(); //要删除的商品SID集合
        if (is_string($data)) {
            $sid['sid'] = $data;
        }
        if (is_array($data) && !isset($data['sid'])) {
            halt('购物车update方法参数错误，缺少sid值');
        }

        $sid = isset($sid[0]) ? $sid : array($sid); //可以一次删除多个商品
        foreach ($sid as $d) {
            foreach ($goods as $k => $v) {
                if ($k == $d['sid']) {
                    unset($goods[$k]);
                }
            }
        }
        self::save($goods);
    }

    /**
     * 清空购物车中的所有商品
     */
    static function delAll()
    {
        $data = array();
        $data['goods'] = array();
        $data['total_rows'] = 0;
        $data['total'] = 0;
        session(self::$cartName, $data);
    }

    /**
     * 获得购物车商品数据
     */
    static function getGoods()
    {
        $data = session(self::$cartName);
        if ($data) {
            return isset($data['goods']) ? $data['goods'] : null;
        }
        $data = array("goods" => array(), "total_rows" => 0, "total" => 0);
        session(self::$cartName, $data);
        return null;
    }

    /**
     * 获得购物车中的所有数据
     * 包括商品数据、总数量、总价格
     */
    static function getAllData()
    {
        return session(self::$cartName);
    }

    /**
     * 获得定单号
     * @return string
     */
    static function getOrderId()
    {
        $year_code = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $i = intval(date('Y')) - 2010-1;
        return $year_code[$i] . date('md').
        substr(time(), -5) . substr(microtime(), 2, 5) . str_pad(mt_rand(1, 99), 2, '0', STR_PAD_LEFT);
    }

}

?>
