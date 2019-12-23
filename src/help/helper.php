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
    $file = APP_PATH . ($module ? 'modules/' . $module . '/' : '') . 'controllers/' . $name . '.php';
    if (file_exists($file)) {
        return false;
    }
    make_dir(dirname($file));
    $myfile = fopen($file, "w") or die("Unable to open file!");
    $txt = "<?php
use thinkyaf\Controller;   
class {$name}Controller extends Controller{
    public function indexAction(){
        echo '欢迎使用thinkyaf开发框架';
    }
}";
    fwrite($myfile, $txt);
    fclose($myfile);
    return true;
}
