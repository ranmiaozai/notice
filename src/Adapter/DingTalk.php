<?php
/**
 *
 * author: qirun.huang
 * since: 2020/10/20 16:50:28
 */

namespace Ranmiaozai\Notice\Adapter;


use Ranmiaozai\Notice\Lib\DingTalk\Robot;

class DingTalk extends NoticeAbstract
{
    private $access_token;
    private $secret;
    private $at_mobiles;
    private $is_all = false;

    public function __construct($config = [])
    {
        $this->at_mobiles = isset($config['at_mobiles'])? $config['at_mobiles']:[];
        $this->access_token = isset($config['access_token'])? $config['access_token']:null;
        $this->secret = isset($config['secret'])? $config['secret']:null;
        $this->is_all = isset($config['is_all'])? $config['is_all']:null;
    }

    public function handle($msg)
    {
        $DingTalk = new Robot($this->access_token, $this->secret);
        $result = $DingTalk->send('text', [
            'content' => $msg,
            'at_mobiles' => $this->at_mobiles,
            'is_all' => $this->is_all
        ]);
        return $result;
    }
}