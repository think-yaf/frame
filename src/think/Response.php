<?php

namespace thinkyaf\think;
use Yaf\Response_Abstract;
use Yaf\Response\Http;
class Response extends Response_Abstract
{
    static function send($data = '', $type = 'json')
    { 
        header('Content-Type:application/json; charset=utf-8'); 
        $rs = json_encode($data, JSON_UNESCAPED_UNICODE);
        echo $rs;
    }
}
