<?php
namespace Ranmiaozai\Notice;
/**
 * 通知接口类
 * Interface NoticeInterface
 * @package Notice
 */
interface NoticeInterface
{
    /**
     * 发送消息操作
     * @param array|string|object $msg
     * @return boolean
     */
    public function handle($msg);

    /**
     * 获取报错
     * @return string|\Exception
     */
    public function getError();

    /**
     * 获取消息类型
     * @return string
     */
    public function getNoticeName();
}