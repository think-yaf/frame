<?php

namespace thinkyaf;

use \Yaf\Application;
use Yaf\Dispatcher;
use Yaf\Loader;

define("Think_PATH",  realpath(dirname(__FILE__) . '/'));
class Think
{
    public function __construct()
    {
        // 实例化yaf
        $this->app = new Application(Think_PATH . "/config.ini");
        // 配置信息
        $this->config = Application::app()->getConfig();
        // 设置常量
        define("APP_PATH",  $this->config->application->directory);
        // 加载助手
        Loader::import(Think_PATH . '/help/helper.php');
        // 加载公共文件
        Loader::import(APP_PATH . '/common.php');
        // 关闭模板 
        Dispatcher::getInstance()->disableView();// autoRender(FALSE);
    }
    // 初始化
    function init()
    {
        return $this;
    }
}

