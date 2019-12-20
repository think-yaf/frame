<?php

namespace thinkyaf;

use Yaf\Controller_Abstract;
use thinkyaf\facade\Response;

class Controller extends Controller_Abstract
{ 
    public function send($var)
    {
        Response::send($var);
    }
}
