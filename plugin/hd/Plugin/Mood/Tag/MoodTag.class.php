<?php

class MoodTag
{
    /**
     * 友情链接显示
     * @param $attr 属性
     * @param $content 内容
     * @return int
     */
    public function _mood($attr, $content)
    {
        $php=<<<php
        <script type='text/javascript' src='__WEB__?a=Mood&c=Index&m=index&g=Plugin&mid=<?php echo \$_GET['mid'];?>&aid=<?php echo \$_GET['aid'];?>'></script>
php;
        return $php;
    }
}