<?php

namespace app\core;

class Response
{
    public function setStatusCode(int $code)
    {
        // Se encarga de establecer el codigo de respuesta en los response
        http_response_code($code);
    }

}