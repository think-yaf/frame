<?php

// 测试打印
function pre($rs, $ext = 0)
{
    echo '<pre>';
    print_r($rs);
    echo '</pre>';
    echo '<hr>';
    if ($ext) {
        die();
    }
}
// 逐行读取文件
function read_file($path)
{
    $file = fopen($path, "r");
    $user = array();
    $i = 0;
    while (!feof($file)) {
        $user[$i] = fgets($file);
        $i++;
    }
    fclose($file);
    $user = array_filter($user);
    return $user;
}
