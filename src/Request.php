<?php

namespace thinkyaf;

use Yaf\Request_Abstract;

class Request extends Request_Abstract
{
    function test()
    {
        echo 'fds';
    }

    public function url()
    {
        $url =  $this->getServer('REQUEST_SCHEME') . '://' . $this->getServer('HTTP_HOST') . $this->getServer('REQUEST_URI');
        return $url;
    }
}
