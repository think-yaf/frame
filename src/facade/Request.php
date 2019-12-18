<?php

namespace thinkyaf\facade;

use thinkyaf\help\Facade;

class Request extends Facade
{
    protected static function getFacadeClass()
    {
        return 'thinkyaf\think\Request';
    }
}