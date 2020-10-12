<?php
namespace Ranmiaozai\Notice\Lib\Mail;
include_once __DIR__.'/class.phpmailer.php';
include_once __DIR__.'/class.smtp.php';
class Mail extends \PHPMailer {
    /**
     * @param $site
     * @param $username
     * @param $password
     * @param $fromname
     * @param $email
     * @param $subject
     * @param $content
     * @param int $port
     * @param bool $smtp_auth
     * @return bool
     * @throws \Exception
     */
    public function _send_mail($site, $username, $password, $fromname, $email, $subject, $content, $port =25, $smtp_auth = true){
        try {
            $this->IsSMTP ();
            $this->IsHTML();
            $this->SMTPAuth = $smtp_auth;
            if($site =='smtp.gmail.com' || $port==465){
                $this->SMTPSecure = "ssl";                 // sets the prefix to the servier
            }
            //网易企业邮箱不支持tls
            if ($site == 'smtp.qiye.163.com') {
                $this->SMTPAutoTLS = false;
            }
            $this->Port = $port;
            $this->Host = $site;
            $this->Username = $username;
            $this->Password = $password;
            $this->From = $username;
            $this->FromName = $fromname;
            $this->CharSet = "UTF-8";
            $email_arr = explode(',', $email);
            if ( count($email_arr) > 0 ) {
                foreach ($email_arr as $_email) {
                    if ( !strpos($_email, '@') ) continue;
                    $this->AddAddress ( $_email );
                }
            } else {
                $this->AddAddress ( $email );
            }
            $this->SetFrom($username, $fromname);
            $this->Subject = $subject;
            $this->MsgHTML ( $content );
            $this->Send ();
            $error = $this->smtp->getError();
            if($error["error"]){
                throw new \Exception($error['error'], 1000);
            }
            return true;
        }catch ( \phpmailerException $e ) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}
