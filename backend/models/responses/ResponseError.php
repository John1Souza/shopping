<?php

namespace app\models\responses;

class ResponseError
{
    public $mensagem;

    function __construct($mensagem)
    {
        $this->mensagem = $mensagem;
    }
}
