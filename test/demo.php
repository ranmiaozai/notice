<?php
$rootPath = dirname(__DIR__);
$vendorPath = $rootPath . '/vendor';
require $vendorPath . '/autoload.php';

$Notice=new \Ranmiaozai\Notice\Notice();
$Notice
    ->addDriver(new \Ranmiaozai\Notice\Adapter\WeChat())
    ->addDriver(new \Ranmiaozai\Notice\Adapter\Mail())
    ->handle('test 123');