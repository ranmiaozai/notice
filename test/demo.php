<?php
$rootPath = dirname(__DIR__);
$vendorPath = $rootPath . '/vendor';
require $vendorPath . '/autoload.php';

$Notice=new \Ranmiaozai\Notice\Notice();
$Notice
    ->addDriver(new \Ranmiaozai\Notice\Adapter\DingTalk([
    ]))
    ->handle('test 456');