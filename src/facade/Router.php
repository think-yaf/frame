<?php

namespace thinkyaf\facade;

use thinkyaf\help\Facade;

class Router extends Facade
{
    protected static function getFacadeClass()
    {
        return 'thinkyaf\Router';
    }
}