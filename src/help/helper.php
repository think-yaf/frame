<?php

// 测试打印
function pre($rs, $ext = 0)
{
    echo '<pre>';
    print_r($rs);
    echo '</pre>';
    if ($ext) {
        die();
    }
}
// 逐行读取文件
function read_file($path)
{
    $file = fopen($path, "r");
    $user = [];
    $i = 0;
    while (!feof($file)) {
        $user[$i] = fgets($file);
        $i++;
    }
    fclose($file);
    $user = array_filter($user);
    return $user;
}
//创建目录
function make_dir($path = '')
{
    if ($path) {
        if (!is_dir($path)) {
            mkdir(iconv("UTF-8", "GBK", $path), 0777, true);
        }
        return true;
    }
    return false;
}
// 创建控制器
function make_controller(string $name = 'index', string $module = '')
{
    $name = ucwords($name);
    $file = APP_PATH . ($module ? 'modules/' . ucwords($module) . '/' : '') . 'controllers/' . $name . '.php';
    if (file_exists($file)) {
        return false;
    }
    make_dir(dirname($file));
    $separator = '';
    if (ini_get('yaf.name_separator')) {
        $separator = ini_get('yaf.name_separator');
    }
    if (ini_get('yaf.name_suffix')) {
        $controller_name = $name . $separator . "Controller";
    } else {
        $controller_name = "Controller" . $separator . $name;
    }
    $action_name = 'Index' . 'Action';
    $myfile = fopen($file, "w") or die("Unable to open file!");
    $txt = "<?php
use thinkyaf\Controller;   
class {$controller_name} extends Controller{
    public function {$action_name}(){
        echo '欢迎使用thinkyaf开发框架';
    }
}";
    fwrite($myfile, $txt);
    fclose($myfile);
    return true;
}
// 创建Bootstrap
function make_bootstrap()
{
    $file = APP_PATH . 'Bootstrap' . '.php';
    if (file_exists($file)) {
        return false;
    }
    $myfile = fopen($file, "w") or die("Unable to open file!");
    $txt = "<?php
use  Yaf\Bootstrap_Abstract;   
class Bootstrap extends Bootstrap_Abstract{
    public function _initConfig(){
       //这里写您的代码 
    }
}";
    fwrite($myfile, $txt);
    fclose($myfile);
    return true;
}
