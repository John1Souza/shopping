<?php

namespace app\models\responses;

class Response
{
    public $data;
    public $mensagem;

    function __construct($mensagem = null, $data = null)
    {
        $this->mensagem = $mensagem;
        $this->data = $data;
    }
}
