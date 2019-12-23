<?php

namespace thinkyaf\facade;

use thinkyaf\help\Facade;

class Cache extends Facade
{
    protected static function getFacadeClass()
    {
        return 'thinkyaf\Cache';
    }
}