<?php

namespace thinkyaf;

use \Yaf\Application;
use Yaf\Dispatcher;
use Yaf\Loader;

defined('ROOT_PATH') or define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../../../'));
defined('APP_PATH') or define('APP_PATH', ROOT_PATH . '/application/');
// 框架路径
define("Think_PATH",  realpath(dirname(__FILE__) . '/'));
class Think
{
    public function __construct()
    {
        // 加载助手
        Loader::import(Think_PATH . '/help/helper.php');
        // 获取ini文件
        $ini_dir = APP_PATH . "application.ini";
        // 使用默认配置文件
        if (!file_exists($ini_dir)) {
            if (!copy(Think_PATH . "/application.ini", $ini_dir)) {
                echo ("请创建文件：<br>{$ini_dir}");
                echo '<pre>';
                $con = read_file(Think_PATH . "/application.ini");
                foreach ($con as $ov) {
                    echo $ov;
                }
                die();
            }
        }
        $controller_dir = APP_PATH.'controllers/index.php';
        if($controller_dir){
            echo '默认控制不存在<br>请创建：'.$controller_dir;
            die();
        }
        // 实例化yaf
        $this->app = new Application($ini_dir);
        // 配置信息
        $this->config = Application::app()->getConfig();
        // 加载公共文件
        $common_dir = APP_PATH . '/common.php';
        if (file_exists($ini_dir)) {
            Loader::import($common_dir);
        }
        // 关闭模板 
        Dispatcher::getInstance()->disableView();
    }
    // 初始化
    public function app()
    {
        //跨域
        $this->origin();
        return $this->app;
    }
    // 允许跨域
    protected function origin()
    {
        $header = $this->config->header;
        if ($header->origin) {
            header('Access-Control-Allow-Origin:' . $header->origin);
        }
        if ($header->headers) {
            header("Access-Control-Allow-Headers:" . $header->headers);
        }
        return $this;
    }
}
