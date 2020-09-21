<?php
$rootPath = dirname(__DIR__);
$vendorPath = $rootPath . '/vendor';
require $vendorPath . '/autoload.php';

$Notice=new \Ranmiaozai\Notice\Notice();
$Notice->addDriver(new \Ranmiaozai\Notice\Adapter\WeChat());
var_dump($Notice->handle("启润之鉴黄宝典"));


