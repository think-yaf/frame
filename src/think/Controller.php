<?php

namespace thinkyaf\think;

use Yaf\Controller_Abstract;
use thinkyaf\think\Response;

class Controller extends Controller_Abstract
{ 
    public function send($var)
    {
        Response::send($var);
    }
}
