<?php

/**
 * 短消息管理模型
 * Class MessageModel
 */
class MessageModel extends ViewModel
{
    public $table = 'user_message';
    public $view = array(
        'user' => array(
            'type' => INNER_JOIN,
            'on' => 'user.uid=user_message.from_uid'
        )
    );

    public function __init()
    {
    }
}