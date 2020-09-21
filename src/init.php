<?php
/**
 * 初始化某些依赖等
 */

//注册全局错误处理方法
\Ranmiaozai\Notice\Notice::setErrorHandle(function (\Exception $exception){
    var_dump($exception->getMessage());
});

