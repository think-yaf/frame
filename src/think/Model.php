<?php

namespace thinkyaf\think;

use think\Model as think_model;
use think\facade\Db;

// 数据库连接
Db::setConfig([
    'default'     => 'mysql',
    'connections' => [
        'mysql' => [
            'type'     => 'mysql',
            'hostname' => '127.0.0.1',
            'username' => 'root',
            'password'    => 'root',
            'database' => 'thinkyaf',
            'charset'  => 'utf8',
            'prefix'   => '',
            'debug'    => true,
        ],
    ],
]);

class Model extends think_model
{
    public function initialize()
    {
    }
}
