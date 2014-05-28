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
 * 中文分词
 * @package     tools_class
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
//常量定义
define('_SP_', chr(0xFF) . chr(0xFE));
define('UCS2', 'ucs-2be');

class SplitWord{

//hash算法选项
    static $mask_value = 0xFFFF;
//输入和输出的字符编码（只允许 utf-8、gbk/gb2312/gb18030、big5 三种类型）
    static $sourceCharSet = 'utf-8';
    static $targetCharSet = 'utf-8';
//生成的分词结果数据类型 1 为全部， 2为 词典词汇及单个中日韩简繁字符及英文， 3 为词典词汇及英文
    static $resultType = 1;
//句子长度小于这个数值时不拆分，notSplitLen = n(个汉字) * 2 + 1
    static $notSplitLen = 5;
//把英文单词全部转小写
    static $toLower = FALSE;
//使用最大切分模式对二元词进行消岐
    static $differMax = FALSE;
//尝试合并单字
    static $unitWord = TRUE;
//初始化类时直接加载词典
    static $loadInit = TRUE;
//使用热门词优先模式进行消岐
    static $differFreq = FALSE;
//被转换为unicode的源字符串
    static $sourceString = '';
//附加词典
    static $addonDic = array();
    static $addonDicFile = 'words_addons.dic';
//主词典
    static $dicStr = '';
    static $mainDic = array();
    static $mainDicHand = FALSE;
    static $mainDicInfos = array();
    static $mainDicFile = 'base_dic_full.dic';
//是否直接载入词典（选是载入速度较慢，但解析较快；选否载入较快，但解析较慢，需要时才会载入特定的词条）
    static $mainDicFileZip = 'base_dic_full.zip';
    static $isLoadAll = FALSE;
    static $isUnpacked = FALSE;
//主词典词语最大长度 x / 2
    static $dicWordMax = 14;
//粗分后的数组（通常是截取句子等用途）
    static $simpleResult = array();
//最终结果(用空格分开的词汇列表)
    static $finallyResult = '';
//是否已经载入词典
    static $isLoadDic = FALSE;
//系统识别或合并的新词
    static $newWords = array();
    static $foundWordStr = '';
//词库载入时间
    static $loadTime = 0;
    static $finallyIndex = array();
    static $splitword_path ;//分词扩展目录
    public function __construct() {

    }
    /**
     * 拆分字符串
     * @param type $string      要拆分的字符
     * @param type $source_charset      输入字符的字符编码
     * @param type $target_charset      输出字符的字符编码
     * @return array    拆分后的字符以数组形式返回，键名为字符，键值为字符数量
     */
    static public function splitWord($string, $source_charset = '', $target_charset = 'utf-8', $load_all = TRUE) {
        self::$splitword_path = HDPHP_EXTEND_PATH.'Org/SplitWord/';
        $charset = C("CHARSET");
        $source_charset = empty($source_charset) ? preg_replace("/utf8|utf-8/i", "utf-8", $charset) : $source_charset;
        self::$addonDicFile = self::$splitword_path . self::$addonDicFile;
        self::$mainDicFileZip = self::$splitword_path . self::$mainDicFileZip;
        self::$mainDicFile = self::$splitword_path . self::$mainDicFile;
        self::SetSource($string, $source_charset, $target_charset);
        self::$isLoadAll = $load_all;
        if (file_exists(self::$mainDicFile))
            self::$isUnpacked = TRUE;
        if (self::$loadInit)
            self::LoadDict();
        self::StartAnalysis();
        $string =  self::GetFinallyIndex();
        if(is_array($string)){
            $s = array();
            foreach($string as $k=>$v){
                $k = string::removePunctuation($k);
                // $k = preg_replace("/\w/i",'',$k);
                if(empty($k) || mb_strlen($k,$source_charset)==1){
                    continue;
                }
                $s[$k]=$v;
            }
            $string=$s;
        }
        return $string;
    }

    /**
     * 析构函数
     */
//    function __destruct() {
//        if (self::$mainDicHand !== FALSE) {
//            @fclose(self::$mainDicHand);
//        }
//    }

    /**
     * 根据字符串计算key索引
     * @param $key
     * @return short int
     */
    static private function _get_index($key) {
        $l = strlen($key);
        $h = 0x238f13af;
        while ($l--) {
            $h += ($h << 5);
            $h ^= ord($key[$l]);
            $h &= 0x7fffffff;
        }
        return ($h % self::$mask_value);
    }

    /**
     * 从文件获得词
     * @param $key
     * @param $type (类型 word 或 key_groups)
     * @return short int
     */
    static private function GetWordInfos($key, $type = 'word') {
        if (!self::$mainDicHand) {
            self::$mainDicHand = fopen(self::$mainDicFile, 'r');
        }
        $p = 0;
        $keynum = self::_get_index($key);
        if (isset(self::$mainDicInfos[$keynum])) {
            $data = self::$mainDicInfos[$keynum];
        } else {
//rewind( self::$mainDicHand );
            $move_pos = $keynum * 8;
            fseek(self::$mainDicHand, $move_pos, SEEK_SET);
            $dat = fread(self::$mainDicHand, 8);
            $arr = unpack('I1s/n1l/n1c', $dat);
            if ($arr['l'] == 0) {
                return FALSE;
            }
            fseek(self::$mainDicHand, $arr['s'], SEEK_SET);
            $data = @unserialize(fread(self::$mainDicHand, $arr['l']));
            self::$mainDicInfos[$keynum] = $data;
        }
        if (!is_array($data) || !isset($data[$key])) {

            return FALSE;
        }
        return ($type == 'word' ? $data[$key] : $data);
    }

    /**
     * 设置源字符串
     * @param $source
     * @param $source_charset
     * @param $target_charset
     * =
     * @return bool
     */
    static private function SetSource($source, $source_charset = 'utf-8', $target_charset = 'utf-8') {
        self::$sourceCharSet = strtolower($source_charset);
        self::$targetCharSet = strtolower($target_charset);
        self::$simpleResult = array();
        self::$finallyResult = array();
        self::$finallyIndex = array();
        if ($source != '') {
            $rs = TRUE;
            if (preg_match("/^utf/", $source_charset)) {
                self::$sourceString = @iconv('utf-8', UCS2, $source);
            } else if (preg_match("/^gb/", $source_charset)) {
                self::$sourceString = @iconv('utf-8', UCS2, iconv('gb18030', 'utf-8', $source));
            } else if (preg_match("/^big/", $source_charset)) {
                self::$sourceString = @iconv('utf-8', UCS2, iconv('big5', 'utf-8', $source));
            } else {
                $rs = FALSE;
            }
        } else {
            $rs = FALSE;
        }
        return $rs;
    }

    /**
     * 设置结果类型(只在获取finallyResult才有效)
     * @param $rstype 1 为全部， 2去除特殊符号
     *
     * @return void
     */
    static private function SetResultType($rstype) {
        self::$resultType = $rstype;
    }

    /**
     * 载入词典
     *
     * @return void
     */
    static function LoadDict($maindic = '') {
        self::$addonDicFile = self::$addonDicFile;
        self::$mainDicFile = self::$mainDicFile;
        self::$mainDicFileZip = self::$mainDicFileZip;
        $startt = microtime(TRUE);
//正常读取文件
        $dicAddon = self::$addonDicFile;
        if ($maindic == '' || !file_exists($maindic)) {
            $dicWords = self::$mainDicFile;
        } else {
            $dicWords = $maindic;
            self::$mainDicFile = $maindic;
        }

//加载主词典（只打开）
        if (self::$isUnpacked) {
            self::$mainDicHand = fopen($dicWords, 'r');
        } else {
            self::$InportDict(self::$mainDicFileZip);
        }

//载入副词典
        $hw = '';
        $ds = file($dicAddon);
        foreach ($ds as $d) {
            $d = trim($d);
            if ($d == '')
                continue;
            $estr = substr($d, 1, 1);
            if ($estr == ':') {
                $hw = substr($d, 0, 1);
            } else {
                $spstr = _SP_;
                $spstr = iconv(UCS2, 'utf-8', $spstr);
                $ws = explode(',', $d);
                $wall = iconv('utf-8', UCS2, join($spstr, $ws));
                $ws = explode(_SP_, $wall);
                foreach ($ws as $estr) {
                    self::$addonDic[$hw][$estr] = strlen($estr);
                }
            }
        }
        self::$loadTime = microtime(TRUE) - $startt;
        self::$isLoadDic = TRUE;
    }

    /**
     * 检测某个词是否存在
     */
    static private function IsWord($word) {
        $winfos = self::GetWordInfos($word);
        return ($winfos !== FALSE);
    }

    /**
     * 获得某个词的词性及词频信息
     * @parem $word unicode编码的词
     * @return void
     */
    static private function GetWordProperty($word) {
        if (strlen($word) < 4) {
            return '/s';
        }
        $infos = self::GetWordInfos($word);
        return isset($infos[1]) ? "/{$infos[1]}{$infos[0]}" : "/s";
    }

    /**
     * 指定某词的词性信息（通常是新词）
     * @parem $word unicode编码的词
     * @parem $infos array('c' => 词频, 'm' => 词性);
     * @return void;
     */
    static private function SetWordInfos($word, $infos) {
        if (strlen($word) < 4) {
            return;
        }
        if (isset(self::$mainDicInfos[$word])) {
            self::$newWords[$word]++;
            self::$mainDicInfos[$word]['c']++;
        } else {
            self::$newWords[$word] = 1;
            self::$mainDicInfos[$word] = $infos;
        }
    }

    /**
     * 开始执行分析
     * @parem bool optimize 是否对结果进行优化
     * @return bool
     */
    static private function StartAnalysis($optimize = TRUE) {
        if (!self::$isLoadDic) {
            self::$LoadDict();
        }
        self::$simpleResult = self::$finallyResult = array();
        self::$sourceString .= chr(0) . chr(32);
        $slen = strlen(self::$sourceString);
        $sbcArr = array();
        $j = 0;
//全角与半角字符对照表
        for ($i = 0xFF00; $i < 0xFF5F; $i++) {
            $scb = 0x20 + $j;
            $j++;
            $sbcArr[$i] = $scb;
        }
//对字符串进行粗分
        $onstr = '';
        $lastc = 1; //1 中/韩/日文, 2 英文/数字/符号('.', '@', '#', '+'), 3 ANSI符号 4 纯数字 5 非ANSI符号或不支持字符
        $s = 0;
        $ansiWordMatch = "[0-9a-z@#%\+\.-]";
        $notNumberMatch = "[a-z@#%\+]";
        for ($i = 0; $i < $slen; $i++) {
            $c = self::$sourceString[$i] . self::$sourceString[++$i];
            $cn = hexdec(bin2hex($c));
            $cn = isset($sbcArr[$cn]) ? $sbcArr[$cn] : $cn;
//ANSI字符
            if ($cn < 0x80) {
                if (preg_match('/' . $ansiWordMatch . '/i', chr($cn))) {
                    if ($lastc != 2 && $onstr != '') {
                        self::$simpleResult[$s]['w'] = $onstr;
                        self::$simpleResult[$s]['t'] = $lastc;
                        self::_deep_analysis($onstr, $lastc, $s, $optimize);
                        $s++;
                        $onstr = '';
                    }
                    $lastc = 2;
                    $onstr .= chr(0) . chr($cn);
                } else {
                    if ($onstr != '') {
                        self::$simpleResult[$s]['w'] = $onstr;
                        if ($lastc == 2) {
                            if (!preg_match('/' . $notNumberMatch . '/i', iconv(UCS2, 'utf-8', $onstr)))
                                $lastc = 4;
                        }
                        self::$simpleResult[$s]['t'] = $lastc;
                        if ($lastc != 4)
                            self::_deep_analysis($onstr, $lastc, $s, $optimize);
                        $s++;
                    }
                    $onstr = '';
                    $lastc = 3;
                    if ($cn < 31) {
                        continue;
                    } else {
                        self::$simpleResult[$s]['w'] = chr(0) . chr($cn);
                        self::$simpleResult[$s]['t'] = 3;
                        $s++;
                    }
                }
            }
//普通字符
            else {
//正常文字
                if (($cn > 0x3FFF && $cn < 0x9FA6) || ($cn > 0xF8FF && $cn < 0xFA2D)
                        || ($cn > 0xABFF && $cn < 0xD7A4) || ($cn > 0x3040 && $cn < 0x312B)) {
                    if ($lastc != 1 && $onstr != '') {
                        self::$simpleResult[$s]['w'] = $onstr;
                        if ($lastc == 2) {
                            if (!preg_match('/' . $notNumberMatch . '/i', iconv(UCS2, 'utf-8', $onstr)))
                                $lastc = 4;
                        }
                        self::$simpleResult[$s]['t'] = $lastc;
                        if ($lastc != 4)
                            self::_deep_analysis($onstr, $lastc, $s, $optimize);
                        $s++;
                        $onstr = '';
                    }
                    $lastc = 1;
                    $onstr .= $c;
                }
//特殊符号
                else {
                    if ($onstr != '') {
                        self::$simpleResult[$s]['w'] = $onstr;
                        if ($lastc == 2) {
                            if (!preg_match('/' . $notNumberMatch . '/i', iconv(UCS2, 'utf-8', $onstr)))
                                $lastc = 4;
                        }
                        self::$simpleResult[$s]['t'] = $lastc;
                        if ($lastc != 4)
                            self::_deep_analysis($onstr, $lastc, $s, $optimize);
                        $s++;
                    }

//检测书名
                    if ($cn == 0x300A) {
                        $tmpw = '';
                        $n = 1;
                        $isok = FALSE;
                        $ew = chr(0x30) . chr(0x0B);
                        while (TRUE) {
                            if (!isset(self::$sourceString[$i + $n]) && !isset(self::$sourceString[$i + $n + 1]))
                                break;
                            $w = self::$sourceString[$i + $n] . self::$sourceString[$i + $n + 1];
                            if ($w == $ew) {
                                self::$simpleResult[$s]['w'] = $c;
                                self::$simpleResult[$s]['t'] = 5;
                                $s++;

                                self::$simpleResult[$s]['w'] = $tmpw;
                                self::$newWords[$tmpw] = 1;
                                if (!isset(self::$newWords[$tmpw])) {
                                    self::$foundWordStr .= self::_out_string_encoding($tmpw) . '/nb, ';
                                    self::SetWordInfos($tmpw, array('c' => 1, 'm' => 'nb'));
                                }
                                self::$simpleResult[$s]['t'] = 13;

                                $s++;

//最大切分模式对书名继续分词
                                if (self::$differMax) {
                                    self::$simpleResult[$s]['w'] = $tmpw;
                                    self::$simpleResult[$s]['t'] = 21;
                                    self::_deep_analysis($tmpw, $lastc, $s, $optimize);
                                    $s++;
                                }

                                self::$simpleResult[$s]['w'] = $ew;
                                self::$simpleResult[$s]['t'] = 5;
                                $s++;

                                $i = $i + $n + 1;
                                $isok = TRUE;
                                $onstr = '';
                                $lastc = 5;
                                break;
                            } else {
                                $n = $n + 2;
                                $tmpw .= $w;
                                if (strlen($tmpw) > 60) {
                                    break;
                                }
                            }
                        }//while
                        if (!$isok) {
                            self::$simpleResult[$s]['w'] = $c;
                            self::$simpleResult[$s]['t'] = 5;
                            $s++;
                            $onstr = '';
                            $lastc = 5;
                        }
                        continue;
                    }

                    $onstr = '';
                    $lastc = 5;
                    if ($cn == 0x3000) {
                        continue;
                    } else {
                        self::$simpleResult[$s]['w'] = $c;
                        self::$simpleResult[$s]['t'] = 5;
                        $s++;
                    }
                }//2byte symbol
            }//end 2byte char
        }//end for
//处理分词后的结果
        self::_sort_finally_result();
    }

    /**
     * 深入分词
     * @parem $str
     * @parem $ctype (2 英文类， 3 中/韩/日文类)
     * @parem $spos   当前粗分结果游标
     * @return bool
     */
    static private function _deep_analysis(&$str, $ctype, $spos, $optimize = TRUE) {

//中文句子
        if ($ctype == 1) {
            $slen = strlen($str);
//小于系统配置分词要求长度的句子
            if ($slen < self::$notSplitLen) {
                $tmpstr = '';
                $lastType = 0;
                if ($spos > 0)
                    $lastType = self::$simpleResult[$spos - 1]['t'];
                if ($slen < 5) {
//echo iconv(UCS2, 'utf-8', $str).'<br/>';
                    if ($lastType == 4 && ( isset(self::$addonDic['u'][$str]) || isset(self::$addonDic['u'][substr($str, 0, 2)]) )) {
                        $str2 = '';
                        if (!isset(self::$addonDic['u'][$str]) && isset(self::$addonDic['s'][substr($str, 2, 2)])) {
                            $str2 = substr($str, 2, 2);
                            $str = substr($str, 0, 2);
                        }
                        $ww = self::$simpleResult[$spos - 1]['w'] . $str;
                        self::$simpleResult[$spos - 1]['w'] = $ww;
                        self::$simpleResult[$spos - 1]['t'] = 4;
                        if (!isset(self::$newWords[self::$simpleResult[$spos - 1]['w']])) {
                            self::$foundWordStr .= self::_out_string_encoding($ww) . '/mu, ';
                            self::SetWordInfos($ww, array('c' => 1, 'm' => 'mu'));
                        }
                        self::$simpleResult[$spos]['w'] = '';
                        if ($str2 != '') {
                            self::$finallyResult[$spos - 1][] = $ww;
                            self::$finallyResult[$spos - 1][] = $str2;
                        }
                    } else {
                        self::$finallyResult[$spos][] = $str;
                    }
                } else {
                    self::_deep_analysis_cn($str, $ctype, $spos, $slen, $optimize);
                }
            }
//正常长度的句子，循环进行分词处理
            else {
                self::_deep_analysis_cn($str, $ctype, $spos, $slen, $optimize);
            }
        }
//英文句子，转为小写
        else {
            if (self::$toLower) {
                self::$finallyResult[$spos][] = strtolower($str);
            } else {
                self::$finallyResult[$spos][] = $str;
            }
        }
    }

    /**
     * 中文的深入分词
     * @parem $str
     * @return void
     */
    static private function _deep_analysis_cn(&$str, $lastec, $spos, $slen, $optimize = TRUE) {
        $quote1 = chr(0x20) . chr(0x1C);
        $tmparr = array();
        $hasw = 0;
//如果前一个词为 “ ， 并且字符串小于3个字符当成一个词处理。
        if ($spos > 0 && $slen < 11 && self::$simpleResult[$spos - 1]['w'] == $quote1) {
            $tmparr[] = $str;
            if (!isset(self::$newWords[$str])) {
                self::$foundWordStr .= self::_out_string_encoding($str) . '/nq, ';
                self::SetWordInfos($str, array('c' => 1, 'm' => 'nq'));
            }
            if (!self::$differMax) {
                self::$finallyResult[$spos][] = $str;
                return;
            }
        }
//进行切分
        for ($i = $slen - 1; $i > 0; $i -= 2) {
//单个词
            $nc = $str[$i - 1] . $str[$i];
//是否已经到最后两个字
            if ($i <= 2) {
                $tmparr[] = $nc;
                $i = 0;
                break;
            }
            $isok = FALSE;
            $i = $i + 1;
            for ($k = self::$dicWordMax; $k > 1; $k = $k - 2) {
                if ($i < $k)
                    continue;
                $w = substr($str, $i - $k, $k);
                if (strlen($w) <= 2) {
                    $i = $i - 1;
                    break;
                }
                if (self::IsWord($w)) {
                    $tmparr[] = $w;
                    $i = $i - $k + 1;
                    $isok = TRUE;
                    break;
                }
            }
//echo '<hr />';
//没适合词
            if (!$isok)
                $tmparr[] = $nc;
        }
        $wcount = count($tmparr);
        if ($wcount == 0)
            return;
        self::$finallyResult[$spos] = array_reverse($tmparr);
//优化结果(岐义处理、新词、数词、人名识别等)
        if ($optimize) {
            self::_optimize_result(self::$finallyResult[$spos], $spos);
        }
    }

    /**
     * 对最终分词结果进行优化（把simpleresult结果合并，并尝试新词识别、数词合并等）
     * @parem $optimize 是否优化合并的结果
     * @return bool
     */
//t = 1 中/韩/日文, 2 英文/数字/符号('.', '@', '#', '+'), 3 ANSI符号 4 纯数字 5 非ANSI符号或不支持字符
    static private function _optimize_result(&$smarr, $spos) {
        $newarr = array();
        $prePos = $spos - 1;
        $arlen = count($smarr);
        $i = $j = 0;
        //检测数量词
        if ($prePos > -1 && !isset(self::$finallyResult[$prePos])) {
            $lastw = self::$simpleResult[$prePos]['w'];
            $lastt = self::$simpleResult[$prePos]['t'];
            if (($lastt == 4 || isset(self::$addonDic['c'][$lastw])) && isset(self::$addonDic['u'][$smarr[0]])) {
                self::$simpleResult[$prePos]['w'] = $lastw . $smarr[0];
                self::$simpleResult[$prePos]['t'] = 4;
                if (!isset(self::$newWords[self::$simpleResult[$prePos]['w']])) {
                    self::$foundWordStr .= self::_out_string_encoding(self::$simpleResult[$prePos]['w']) . '/mu, ';
                    self::SetWordInfos(self::$simpleResult[$prePos]['w'], array('c' => 1, 'm' => 'mu'));
                }
                $smarr[0] = '';
                $i++;
            }
        }
        for (; $i < $arlen; $i++) {

            if (!isset($smarr[$i + 1])) {
                $newarr[$j] = $smarr[$i];
                break;
            }
            $cw = $smarr[$i];
            $nw = $smarr[$i + 1];
            $ischeck = FALSE;
            //检测数量词
            if (isset(self::$addonDic['c'][$cw]) && isset(self::$addonDic['u'][$nw])) {
            //最大切分时保留合并前的词
                if (self::$differMax) {
                    $newarr[$j] = chr(0) . chr(0x28);
                    $j++;
                    $newarr[$j] = $cw;
                    $j++;
                    $newarr[$j] = $nw;
                    $j++;
                    $newarr[$j] = chr(0) . chr(0x29);
                    $j++;
                }
                $newarr[$j] = $cw . $nw;
                if (!isset(self::$newWords[$newarr[$j]])) {
                    self::$foundWordStr .= self::_out_string_encoding($newarr[$j]) . '/mu, ';
                    self::SetWordInfos($newarr[$j], array('c' => 1, 'm' => 'mu'));
                }
                $j++;
                $i++;
                $ischeck = TRUE;
            }
//检测前导词(通常是姓)
            else if (isset(self::$addonDic['n'][$smarr[$i]])) {
                $is_rs = FALSE;
//词语是副词或介词或频率很高的词不作为人名
                if (strlen($nw) == 4) {
                    $winfos = self::GetWordInfos($nw);
                    if (isset($winfos['m']) && ($winfos['m'] == 'r' || $winfos['m'] == 'c' || $winfos['c'] > 500)) {
                        $is_rs = TRUE;
                    }
                }
                if (!isset(self::$addonDic['s'][$nw]) && strlen($nw) < 5 && !$is_rs) {
                    $newarr[$j] = $cw . $nw;
//echo iconv(UCS2, 'utf-8', $newarr[$j])."<br />";
//尝试检测第三个词
                    if (strlen($nw) == 2 && isset($smarr[$i + 2]) && strlen($smarr[$i + 2]) == 2 && !isset(self::$addonDic['s'][$smarr[$i + 2]])) {
                        $newarr[$j] .= $smarr[$i + 2];
                        $i++;
                    }
                    if (!isset(self::$newWords[$newarr[$j]])) {
                        self::SetWordInfos($newarr[$j], array('c' => 1, 'm' => 'nr'));
                        self::$foundWordStr .= self::_out_string_encoding($newarr[$j]) . '/nr, ';
                    }
//为了防止错误，保留合并前的姓名
                    if (strlen($nw) == 4) {
                        $j++;
                        $newarr[$j] = chr(0) . chr(0x28);
                        $j++;
                        $newarr[$j] = $cw;
                        $j++;
                        $newarr[$j] = $nw;
                        $j++;
                        $newarr[$j] = chr(0) . chr(0x29);
                    }

                    $j++;
                    $i++;
                    $ischeck = TRUE;
                }
            }
//检测后缀词(地名等)
            else if (isset(self::$addonDic['a'][$nw])) {
                $is_rs = FALSE;
//词语是副词或介词不作为前缀
                if (strlen($cw) > 2) {
                    $winfos = self::GetWordInfos($cw);
                    if (isset($winfos['m']) && ($winfos['m'] == 'a' || $winfos['m'] == 'r' || $winfos['m'] == 'c' || $winfos['c'] > 500)) {
                        $is_rs = TRUE;
                    }
                }
                if (!isset(self::$addonDic['s'][$cw]) && !$is_rs) {
                    $newarr[$j] = $cw . $nw;
                    if (!isset(self::$newWords[$newarr[$j]])) {
                        self::$foundWordStr .= self::_out_string_encoding($newarr[$j]) . '/na, ';
                        self::SetWordInfos($newarr[$j], array('c' => 1, 'm' => 'na'));
                    }
                    $i++;
                    $j++;
                    $ischeck = TRUE;
                }
            }
//新词识别（暂无规则）
            else if (self::$unitWord) {
                if (strlen($cw) == 2 && strlen($nw) == 2
                        && !isset(self::$addonDic['s'][$cw]) && !isset(self::$addonDic['t'][$cw]) && !isset(self::$addonDic['a'][$cw])
                        && !isset(self::$addonDic['s'][$nw]) && !isset(self::$addonDic['c'][$nw])) {
                    $newarr[$j] = $cw . $nw;
//尝试检测第三个词
                    if (isset($smarr[$i + 2]) && strlen($smarr[$i + 2]) == 2 && (isset(self::$addonDic['a'][$smarr[$i + 2]]) || isset(self::$addonDic['u'][$smarr[$i + 2]]))) {
                        $newarr[$j] .= $smarr[$i + 2];
                        $i++;
                    }
                    if (!isset(self::$newWords[$newarr[$j]])) {
                        self::$foundWordStr .= self::_out_string_encoding($newarr[$j]) . '/ms, ';
                        self::SetWordInfos($newarr[$j], array('c' => 1, 'm' => 'ms'));
                    }
                    $i++;
                    $j++;
                    $ischeck = TRUE;
                }
            }

//不符合规则
            if (!$ischeck) {
                $newarr[$j] = $cw;
//二元消岐处理——最大切分模式
                if (self::$differMax && !isset(self::$addonDic['s'][$cw]) && strlen($cw) < 5 && strlen($nw) < 7) {
                    $slen = strlen($nw);
                    $hasDiff = FALSE;
                    for ($y = 2; $y <= $slen - 2; $y = $y + 2) {
                        $nhead = substr($nw, $y - 2, 2);
                        $nfont = $cw . substr($nw, 0, $y - 2);
                        if (self::$IsWord($nfont . $nhead)) {
                            if (strlen($cw) > 2)
                                $j++;
                            $hasDiff = TRUE;
                            $newarr[$j] = $nfont . $nhead;
                        }
                    }
                }
                $j++;
            }
        }//end for
        $smarr = $newarr;
    }

    /**
     * 转换最终分词结果到 finallyResult 数组
     * @return void
     */
    static private function _sort_finally_result() {
        $newarr = array();
        $i = 0;
        foreach (self::$simpleResult as $k => $v) {
            if (empty($v['w']))
                continue;
            if (isset(self::$finallyResult[$k]) && count(self::$finallyResult[$k]) > 0) {
                foreach (self::$finallyResult[$k] as $w) {
                    if (!empty($w)) {
                        $newarr[$i]['w'] = $w;
                        $newarr[$i]['t'] = 20;
                        $i++;
                    }
                }
            } else if ($v['t'] != 21) {
                $newarr[$i]['w'] = $v['w'];
                $newarr[$i]['t'] = $v['t'];
                $i++;
            }
        }
        self::$finallyResult = $newarr;
        $newarr = '';
    }

    /**
     * 把uncode字符串转换为输出字符串
     * @parem str
     * return string
     */
    static private function _out_string_encoding(&$str) {
        $rsc = self::_source_result_charset();
        if ($rsc == 1) {
            $rsstr = iconv(UCS2, 'utf-8', $str);
        } else if ($rsc == 2) {
            $rsstr = iconv('utf-8', 'gb18030', iconv(UCS2, 'utf-8', $str));
        } else {
            $rsstr = iconv('utf-8', 'big5', iconv(UCS2, 'utf-8', $str));
        }
        return $rsstr;
    }

    /**
     * 获取最终结果字符串（用空格分开后的分词结果）
     * @return string
     */
    static function GetFinallyResult($spword = ' ', $word_meanings = FALSE) {
        $rsstr = '';
        foreach (self::$finallyResult as $v) {
            if (self::$resultType == 2 && ($v['t'] == 3 || $v['t'] == 5)) {
                continue;
            }
            $m = '';
            if ($word_meanings) {
                $m = self::GetWordProperty($v['w']);
            }
            $w = self::_out_string_encoding($v['w']);
            if ($w != ' ') {
                if ($word_meanings) {
                    $rsstr .= $spword . $w . $m;
                } else {
                    $rsstr .= $spword . $w;
                }
            }
        }
        return $rsstr;
    }

    /**
     * 获取粗分结果，不包含粗分属性
     * @return array()
     */
    static private function GetSimpleResult() {
        $rearr = array();
        foreach (self::$simpleResult as $k => $v) {
            if (empty($v['w']))
                continue;
            $w = self::_out_string_encoding($v['w']);
            if ($w != ' ')
                $rearr[] = $w;
        }
        return $rearr;
    }

    /**
     * 获取粗分结果，包含粗分属性（1中文词句、2 ANSI词汇（包括全角），3 ANSI标点符号（包括全角），4数字（包括全角），5 中文标点或无法识别字符）
     * @return array()
     */
    function GetSimpleResultAll() {
        $rearr = array();
        foreach (self::$simpleResult as $k => $v) {
            $w = self::_out_string_encoding($v['w']);
            if ($w != ' ') {
                $rearr[$k]['w'] = $w;
                $rearr[$k]['t'] = $v['t'];
            }
        }
        return $rearr;
    }

    /**
     * 获取索引hash数组
     * @return array('word'=>count,...)
     */
    static private function GetFinallyIndex() {
        $rearr = array();
        foreach (self::$finallyResult as $v) {
            if (self::$resultType == 2 && ($v['t'] == 3 || $v['t'] == 5)) {
                continue;
            }
            $w = self::_out_string_encoding($v['w']);
            if ($w == ' ') {
                continue;
            }
            if (isset($rearr[$w])) {
                $rearr[$w]++;
            } else {
                $rearr[$w] = 1;
            }
        }
        return $rearr;
    }

    /**
     * 获得保存目标编码
     * @return int
     */
    static private function _source_result_charset() {
        if (preg_match("/^utf/", self::$targetCharSet)) {
            $rs = 1;
        } else if (preg_match("/^gb/", self::$targetCharSet)) {
            $rs = 2;
        } else if (preg_match("/^big/", self::$targetCharSet)) {
            $rs = 3;
        } else {
            $rs = 4;
        }
        return $rs;
    }

    /**
     * 编译词典
     * @parem $sourcefile utf-8编码的文本词典数据文件<参见范例dict/not-build/base_dic_full.txt>
     * 注意, 需要PHP开放足够的内存才能完成操作
     * @return void
     */
    static private function MakeDict($source_file, $target_file = '') {
        $target_file = ($target_file == '' ? self::$mainDicFile : $target_file);
        $allk = array();
        $fp = fopen($source_file, 'r');
        while ($line = fgets($fp, 512)) {
            if ($line[0] == '@')
                continue;
            list($w, $r, $a) = explode(',', $line);
            $a = trim($a);
            $w = iconv('utf-8', UCS2, $w);
            $k = self::_get_index($w);
            if (isset($allk[$k]))
                $allk[$k][$w] = array($r, $a);
            else
                $allk[$k][$w] = array($r, $a);
        }
        fclose($fp);
        $fp = fopen($target_file, 'w');
        $heade_rarr = array();
        $alldat = '';
        $start_pos = self::$mask_value * 8;
        foreach ($allk as $k => $v) {
            $dat = serialize($v);
            $dlen = strlen($dat);
            $alldat .= $dat;

            $heade_rarr[$k][0] = $start_pos;
            $heade_rarr[$k][1] = $dlen;
            $heade_rarr[$k][2] = count($v);

            $start_pos += $dlen;
        }
        unset($allk);
        for ($i = 0; $i < self::$mask_value; $i++) {
            if (!isset($heade_rarr[$i])) {
                $heade_rarr[$i] = array(0, 0, 0);
            }
            fwrite($fp, pack("Inn", $heade_rarr[$i][0], $heade_rarr[$i][1], $heade_rarr[$i][2]));
        }
        fwrite($fp, $alldat);
        fclose($fp);
    }

    /**
     * 导出词典的词条
     * @parem $targetfile 保存位置
     * @return void
     */
    static private function ExportDict($targetfile) {
        if (!self::$mainDicHand) {
            self::$mainDicHand = fopen(self::$mainDicFile, 'rw');
        }
        $fp = fopen($targetfile, 'w');
        for ($i = 0; $i <= self::$mask_value; $i++) {
            $move_pos = $i * 8;
            fseek(self::$mainDicHand, $move_pos, SEEK_SET);
            $dat = fread(self::$mainDicHand, 8);
            $arr = unpack('I1s/n1l/n1c', $dat);
            if ($arr['l'] == 0) {
                continue;
            }
            fseek(self::$mainDicHand, $arr['s'], SEEK_SET);
            $data = @unserialize(fread(self::$mainDicHand, $arr['l']));
            if (!is_array($data))
                continue;
            foreach ($data as $k => $v) {
                $w = iconv(UCS2, 'utf-8', $k);
                fwrite($fp, "{$w},{$v[0]},{$v[1]}\n");
            }
        }
        fclose($fp);
        return TRUE;
    }

}
?>