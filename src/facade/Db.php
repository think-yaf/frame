<?php

namespace thinkyaf\facade;

use thinkyaf\help\Facade;

class Db extends Facade
{
    //始终创建新的对象实例
    //protected static $alwaysNewInstance = 1;
    protected static function getFacadeClass()
    {
        return 'thinkyaf\Db';
    }
}
