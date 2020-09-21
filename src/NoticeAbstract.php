<?php

namespace Ranmiaozai\Notice;
/**
 * 通知抽象类
 * Class NoticeAbstract
 * @package Notice
 */
abstract class NoticeAbstract
{
    /**
     * 报错信息
     * @var null
     */
    protected $_error = null;
    /**
     * 当前通知类名称,如WeChat等
     * @var null
     */
    protected $typeName = null;

    /**
     * 获取通知类型名称
     * @return null|string
     */
    public function getNoticeName()
    {
        if (empty($this->typeName)) {
            try {
                $name = new \ReflectionClass(get_called_class());
                $this->typeName = $name->getShortName();
            } catch (\Exception $exception) {
                $this->typeName = get_called_class();
            }
        }
        return $this->typeName;
    }

    /**
     * 获取报错信息
     * @return null
     */
    public function getError()
    {
        return $this->_error;
    }
}