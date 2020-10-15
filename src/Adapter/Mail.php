<?php
/**
 * 邮件推送
 * author: qirun.huang
 * since: 2020/10/12 14:58:22
 */

namespace Ranmiaozai\Notice\Adapter;


class Mail extends NoticeAbstract
{
    /**
     * smtp.163.com
     */
    private $site;

    /**
     * @var mixed
     */
    private $username;

    /**
     * @var mixed
     */
    private $password;


    private $from_name;

    /**
     * to email
     * @var mixed
     */
    private $to_email;

    /**
     * 主题
     * @var mixed
     */
    private $subject;

    /**
     * 内容
     * @var mixed
     */
    private $content;

    private $port;

    public function __construct(array $config = [])
    {
        $this->site = $config['site'];
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->from_name = $config['from_name'];
        $this->to_email = $config['to_email'];
        $this->subject = $config['subject'];
        $this->content = $config['content'];
        $this->port = $config['port'];
    }

    public function handle($msg = '')
    {
        $Mail = new \Ranmiaozai\Notice\Lib\Mail\Mail();
        try {
            return $Mail->_send_mail($this->site, $this->username, $this->password, $this->from_name, $this->to_email, $this->subject, $this->content, $this->port);
        } catch (\Exception  $exception) {
            $this->_error = $exception;
            return false;
        }
    }


}