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
