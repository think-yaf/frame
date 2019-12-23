<?php

namespace thinkyaf;

use thinkyaf\library\Redis;

class Cache extends Redis
{
    public function __construct(array $options = null)
    {
        //$this->driver = new Redis($options);
        parent::__construct($options);
    }
    /*
    //切换
    public function store(string $name = null)
    {
        return $this->driver;
    }
    // 获取
    public function get()
    {
        return $this;
    }
    // 设置
    public function set()
    {
        return $this;
    }
    // 删除
    public function del()
    {
        return $this;
    }
    // 清除
    public function clear()
    {
        return $this;
    }
    */
}
