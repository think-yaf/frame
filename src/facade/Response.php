<?php

namespace thinkyaf\facade;

use thinkyaf\help\Facade;

class Response extends Facade
{
    protected static function getFacadeClass()
    {
        return 'thinkyaf\think\Response';
    }
}