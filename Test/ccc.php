<?php
$rootPath = dirname(__DIR__);
$vendorPath = $rootPath . '/vendor';
require $vendorPath . '/autoload.php';

$Notice=new \Notice\Notice();
$Notice->addDriver(new \Notice\Adapter\WeChat());
var_dump($Notice->handle("通天之   哈哈哈哈"));


