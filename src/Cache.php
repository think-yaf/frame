<?php

namespace thinkyaf;

use thinkyaf\library\Redis;

class Cache
{
    public function __construct($options = null)
    {
         return $this->store($options);
    }

    //切换
    public function store($name = null)
    {
        $redis = new Redis();
        $redis->connect(['host' => '127.0.0.1', 'port' => 6379]);
        $this->driver = $redis;
        return $this->driver;
    }
}
