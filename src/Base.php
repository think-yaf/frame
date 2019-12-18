<?php

namespace thinkyaf;

use \Yaf\Application;
use Yaf\Dispatcher;
use Yaf\Loader;

define("Think_PATH",  realpath(dirname(__FILE__) . '/'));
class Base
{
    public function __construct()
    {
        $this->app = new Application(Think_PATH . "/thinkyaf.ini");
        $this->config = Application::app()->getConfig();
        // 设置常量
        define("APP_PATH",  $this->config->application->directory);
        // 加载公共文件
        Loader::import(APP_PATH . '/common.php');
        Dispatcher::getInstance()->autoRender(FALSE);
    }
    // 初始化
    function init()
    {
        return $this;
    }
}
