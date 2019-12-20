<?php

namespace thinkyaf\facade;

use thinkyaf\help\Facade;

class Db extends Facade
{
    protected static function getFacadeClass()
    {
        return 'thinkyaf\Db';
    }
}