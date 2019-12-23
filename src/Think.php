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
    // 初始化
    public function __construct()
    {
        // 加载助手
        Loader::import(Think_PATH . '/help/helper.php');
        // 获取ini文件
        $ini_dir = APP_PATH . "application.ini";
        // 使用默认配置文件
        if (!file_exists($ini_dir)) {
            $ini_dir = Think_PATH . "/application.ini";
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
        $this->route();
        $this->origin();
    }
    // 自动模式
    public function auto()
    {
        make_dir(APP_PATH);
        make_dir(APP_PATH . 'library');
        make_dir(APP_PATH . 'models');
        make_dir(APP_PATH . 'plugins');
        make_dir(APP_PATH . 'views');
        // 获取ini文件
        $ini_dir = APP_PATH . "application.ini";
        if (!file_exists($ini_dir)) {
            //copy(Think_PATH . "/application.ini", APP_PATH . "application.ini");
        }
        copy(Think_PATH . "/application.ini", APP_PATH . "application.ini");
        make_controller();
        make_controller('index', 'my');
        return $this;
    }
    // 跨域设置
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
    // 路由设置
    protected function route()
    {
        $dispatcher = Dispatcher::getInstance();
        $routes = $this->config->routes;
        if ($routes) {
            $dispatcher->getRouter()->addConfig($routes);
        }
        $request = $dispatcher->getRequest();
        $base_domain = $this->config->application->domains ? $this->config->application->domain : $request->getServer('SERVER_NAME');
        defined('HTTP_HOST') or define('HTTP_HOST', $request->getServer('HTTP_HOST'));
        defined('SERVER_NAME') or define('SERVER_NAME', $base_domain);
        if ($module = $this->config->module) {
            foreach ($module->toArray() as $key => $m) {
                if (!isset($m['module'])) {
                    $m['module'] = $key;
                }
                $str = '';
                if (substr($m['domain'], 0, 1) == '*') {
                    $str = substr($m['domain'], 1) . '.' . SERVER_NAME;
                    $mr_domain = (str_replace($str, '', HTTP_HOST)) . $str;
                    // 处理主域名
                    if (HTTP_HOST == trim($str, '.')) {
                        $mr_domain = HTTP_HOST;
                    }
                } else {
                    $mr_domain = "{$m['domain']}.".SERVER_NAME;
                }
                if ($m['domain'] == HTTP_HOST || $mr_domain == HTTP_HOST) {
                    $uri = "/{$m['module']}";
                    $request->setModuleName($m['module']);
                    $request->setBaseUri("{$uri}");
                    if (isset($m['controller'])) {
                        $uri .= "/{$m['controller']}";
                        $request->setControllerName($m['controller']);
                    }
                    if (isset($m['action'])) {
                        $uri .= "/{$m['action']}";
                        $request->setActionName($m['action']);
                    }
                    $request->setRequestUri($uri . $request->getRequestUri());
                    break;
                }
            }
            pre($dispatcher->getRequest());
        }
    }
}
