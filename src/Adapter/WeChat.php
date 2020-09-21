<?php

namespace Notice\Adapter;

use Notice\NoticeAbstract;
use Notice\NoticeInterface;

/**
 * 微信通知
 * Class WeChat
 * @package Notice\Adapter
 */
class WeChat extends NoticeAbstract implements NoticeInterface
{
    protected $typeName="微信公众号";
    public function handle($msg)
    {
        return true;
    }
}