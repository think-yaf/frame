<?php

namespace thinkyaf;
use Yaf\Response_Abstract;
class Response extends Response_Abstract
{
    public function send($data = '', $type = 'json')
    { 
        //header('Content-Type:application/json; charset=utf-8'); 
        $rs = json_encode($data, JSON_UNESCAPED_UNICODE);
        echo $rs;
    }
}
