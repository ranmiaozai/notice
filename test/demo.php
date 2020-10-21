<?php
$rootPath = dirname(__DIR__);
$vendorPath = $rootPath . '/vendor';
require $vendorPath . '/autoload.php';

$Notice=new \Ranmiaozai\Notice\Notice();
$Notice
    ->addDriver(new \Ranmiaozai\Notice\Adapter\DingTalk([
        'content'=>'test',
        'access_token'=>'9cd119bea0f59ae0c0daecd90ea1955037f7e810e74744f24d9eb712eafebedc',
        'secret' => 'SEC7883eb4570335511e56ffe38b0f90946ef421f1312a41b3b0aee51aa5e37f993'
    ]))
    ->handle('test 456');