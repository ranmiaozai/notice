<?php
/**
 *
 * author: qirun.huang
 * since: 2020/10/20 17:07:06
 */

namespace Ranmiaozai\Notice\Lib\DingTalk;


class Robot
{
    private $access_token = null;
    const TEMP_URL = 'https://oapi.dingtalk.com/robot/send?';
    private $secret = null;

    public function __construct($access_token, $secret)
    {
        $this->setAccessToken($access_token);
        $this->setSecretToken($secret);
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

    public function getSecretToken()
    {
        return $this->secret;
    }

    public function setSecretToken($secret)
    {
        $this->secret = $secret;
        return $secret;
    }



    public function curlPost($url, $data)
    {
        $ch = curl_init();
        $timeStamp = floor(microtime(true) * 1000);//毫秒时间戳
        $query = ['access_token' => $this->access_token];
        if($this->secret){
            $stringToSign = $timeStamp . "\n" . $this->secret;//需要签名的字符串
            // 进行加密操作 并输出二进制数据
            $signature = hash_hmac('sha256', $stringToSign, $this->secret, true);
            $query['timestamp'] = $timeStamp;
            $query['sign'] = base64_encode($signature);

        }
        $absURL = $url . http_build_query($query);

        curl_setopt($ch, CURLOPT_URL, $absURL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // 不用开启curl证书验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function send($type, $data){
        $method = 'get' . ucfirst($type) .'TypeData';
        if(!method_exists($this, $method)){
            throw new \Exception("robot 的方法 {$method} 不存在", -1000);
        }

        $data =  $this->$method($data);
        return $this->curlPost(self::TEMP_URL, $data);
    }

    private function getTextTypeData($data)
    {
        return [
            'msgtype' => 'text',
            'text' => [
                "content" => $data['content']
            ],
            'at' => [
                'atMobiles' => $data['at_mobiles'],
                'isAtAll' => $data['is_all']
            ]
        ];
    }

    private function getLinkTypeData($data)
    {
        return [
            "msgtype" => "link",
            "link" => [
                "text" => $data['content'],
                "title" => $data['title'],
                "picUrl" => $data['pic_url'],
                "messageUrl" => $data['message_url'],
            ]
        ];
    }

    private function getMarkdownTypeData($data)
    {
        return [
            "msgtype" => "markdown",
            "markdown" => [
                "title" => $data['title'],
                "text" => $data['content']
            ],
            "at" => [
                "atMobiles" => $data['at_mobiles'],
                "isAtAll" => $data['is_all']
            ]
        ];
    }

    private function getActionCardTypeData($data)
    {
        return [
            "actionCard" => [
                "title" => $data['title'],
                "text" => "![screenshot](@lADOpwk3K80C0M0FoA) 
 ### 乔布斯 20 年前想打造的苹果咖啡厅 
 Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划",
                "hideAvatar" => "0",
                "btnOrientation" => "0",
                "btns" => [
                    [
                        "title" => "内容不错",
                        "actionURL" => "https://www.dingtalk.com/"
                    ],
                    [
                        "title" => "不感兴趣",
                        "actionURL" => "https://www.dingtalk.com/"
                    ]
                ]
            ],
            "msgtype" => "actionCard"
        ];
    }

    private function getFeedCardTypeData($data)
    {
        return [
            "feedCard" => [
                "links" => [
                    [
                        "title" => "时代的火车向前开1",
                        "messageURL" => "https://www.dingtalk.com/",
                        "picURL" => "https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1567105217584&di=4c91fefc045f54267edcf8c544e3bd3b&imgtype=0&src=http%3A%2F%2Fk.zol-img.com.cn%2Fdcbbs%2F16420%2Fa16419096_s.jpg"
                    ],
                    [
                        "title" => "时代的火车向前开2",
                        "messageURL" => "https://www.dingtalk.com/",
                        "picURL" => ""
                    ]
                ]
            ],
            "msgtype" => "feedCard"
        ];
    }
}