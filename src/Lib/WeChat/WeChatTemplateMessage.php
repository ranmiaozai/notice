<?php
/**
 *
 * author: qirun.huang
 * since: 2020/10/14 09:45:46
 */

namespace Ranmiaozai\Notice\Lib\WeChat;


class WeChatTemplateMessage
{
    private $access_token = null;
    //请求模板消息的地址
    const TEMP_URL = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=';

    public function __construct($access_token)
    {
        $this->setAccessToken($access_token);
    }

    public function getAccessToken()
    {
        return $this->access_token;
    }

    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
        return $access_token;
    }

    /**
     * 微信模板消息发送
     * @param string $openid 接收用户的openid
     * @param string $template_id
     * @param array $params
     * @param bool|string $info_url
     * @return bool|string
     */
    public function send($openid, $template_id, $params, $info_url = false)
    {
        $url = self::TEMP_URL . $this->getAccessToken();
        $data = [
            'touser' => $openid,
            'template_id' => $template_id,
            'url' => $info_url,
            'data' => $params
        ];
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        return $this->curlPost($url, $json);
    }

    /**
     * 通过CURL发送数据
     * @param string $url 请求的URL地址
     * @param array|string $data 发送的数据
     * @return bool|string
     */
    protected function curlPost($url, $data)
    {
        $ch = curl_init();
        $params[CURLOPT_URL] = $url;    //请求url地址
        $params[CURLOPT_HEADER] = FALSE; //是否返回响应头信息
        $params[CURLOPT_SSL_VERIFYPEER] = false;
        $params[CURLOPT_SSL_VERIFYHOST] = false;
        $params[CURLOPT_RETURNTRANSFER] = true; //是否将结果返回
        $params[CURLOPT_POST] = true;
        $params[CURLOPT_POSTFIELDS] = $data;
        curl_setopt_array($ch, $params); //传入curl参数
        $content = curl_exec($ch); //执行
        curl_close($ch); //关闭连接
        return $content;
    }

}