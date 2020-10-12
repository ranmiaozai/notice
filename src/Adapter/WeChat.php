<?php

namespace Ranmiaozai\Notice\Adapter;



/**
 * 微信通知
 * Class WeChat
 * @package Notice\Adapter
 */
class WeChat extends NoticeAbstract
{
    protected $typeName = "微信公众号";

    public function handle($msg)
    {
        echo 'wechat here';
    }
}