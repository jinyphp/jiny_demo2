<?php

namespace Jiny\Http;

class Request
{
    private $Response;

    public $_headers;
    public $_request;

    public function __construct()
    {
        // echo __CLASS__."\n";
        ob_start();

        // Response 객체를 생성함
        $this->Response = new \Jiny\Http\Response($this);

        /*
        register_shutdown_function(array($this->Response, 'finish'));
        */

        // Request 해더 정보를 읽어 옵니다.
        $this->getHeader();

        // Request Body를 읽음
        if ($this->_headers['HTTP_CONTENT_TYPE'] == 'application/json') {
            $handler = fopen('php://input', 'r');
            $this->_request = stream_get_contents($handler);
        }
        

    }

    public function response()
    {
        return $this->Response;
    }

    private function getHeader()
    {
        if (isset($_SERVER)) {
            $this->_headers = $_SERVER;
        }

        return $this;
    }

}