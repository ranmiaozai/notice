<?php

namespace Ranmiaozai\Notice\Adapter;

use Ranmiaozai\Notice\Lib\WeChat\WeChatTemplateMessage;

/**
 * 微信通知
 * Class WeChat
 * @package Notice\Adapter
 */
class WeChat extends NoticeAbstract
{
    protected $typeName = "微信公众号";
    private $openid;
    private $info_url;
    private $params;
    private $template_id;
    private $access_token;

    public function __construct($config = [])
    {
        $this->openid = $config['openid'];
        $this->template_id = $config['template_id'];
        $this->params = $config['params'];
        $this->info_url = $config['info_url'];
        $this->access_token = $config['access_token'];
    }

    public function handle($msg)
    {
        try {
            $WeChatTemplateMessage = new WeChatTemplateMessage($this->access_token);
            return $WeChatTemplateMessage->send($this->openid, $this->template_id, $this->params, $this->info_url);
        } catch (\Exception $exception) {
            $this->_error = $exception;
            return false;
        }
    }
}