<?php

namespace Ranmiaozai\Notice;

/**
 * Class Notice
 * @package Notice
 */
class Notice
{
    /**
     * @var \SplObjectStorage
     */
    protected $_driver;
    /**
     * 错误信息
     * @var array
     */
    protected $_error = [];
    /**
     * 错误处理函数--全局
     * @var null
     */
    protected static $_error_handle = null;
    /**
     * 错误处理函数--当前实例
     * @var null
     */
    protected $_error_handle_current_instance = null;

    public function __construct(callable $errorHandle = null)
    {
        $this->_driver = new \SplObjectStorage();
        $this->_error_handle_current_instance = $errorHandle;
    }

    /**
     * 添加通知
     * @param NoticeInterface $notice
     * @return $this
     */
    public function addDriver(NoticeInterface $notice)
    {
        if (!$this->_driver->contains($notice)) {
            $this->_driver->attach($notice);
        }
        return $this;
    }

    /**
     * 通知操作
     * @param array|string|object $msg 消息
     * @param callable|null $errorHandle 报错处理方法,不传就使用当前实例报错方法或者全局方法
     * @return array
     */
    public function handle($msg, callable $errorHandle = null)
    {
        $this->_error = [];
        $this->_driver->rewind();
        $result = [];
        while ($this->_driver->valid()) {
            /**
             * @var NoticeInterface $current
             */
            $current = $this->_driver->current();
            $res = null;
            try {
                $res = $current->handle($msg);
                $error = $current->getError();
            } catch (\Exception $exception) {
                $error = $exception;
            }
            if (!empty($error)) {
                $this->setError($current->getNoticeName(), $error, $errorHandle);
            }
            $result[$current->getNoticeName()] = $res === null ? false : $res;
            $this->_driver->next();
        }
        return $result;
    }

    /**
     * 记录报错信息
     * @param string $key
     * @param string|\Exception $value
     * @param callable|null $errorHandle
     */
    protected function setError($key, $value, $errorHandle)
    {
        $this->_error[$key] = $value;
        $error_handle = null;
        if (!empty($errorHandle) && is_callable($errorHandle)) {
            $error_handle = $errorHandle;
        } elseif (!empty($this->_error_handle_current_instance) && is_callable($this->_error_handle_current_instance)) {
            $error_handle = $this->_error_handle_current_instance;
        } elseif (!empty(self::$_error_handle) && is_callable(self::$_error_handle)) {
            $error_handle = self::$_error_handle;
        }
        if (!empty($error_handle) && is_callable($error_handle)) {
            if ($value instanceof \Exception) {
                $e = $value;
            } else {
                $e = new \Exception($key . ":" . $value, 0);
            }
            call_user_func_array($error_handle, [$e]);
        }
    }

    /**
     * 全局设定错误记录方法
     * @param callable $handle
     */
    public static function setErrorHandle(callable $handle)
    {
        self::$_error_handle = $handle;
    }

    /**
     * 获取报错信息
     * @return array
     */
    public function getError()
    {
        return $this->_error;
    }
}