<?php

namespace app\models\responses;

class ResponseList
{
    public $data;
    public $totalRegistros;
    public $totalRegistrosPaginaAtual; // @ TODO - REMOVER

    function __construct($data = null, $totalRegistros = null, $totalRegistrosPaginaAtual = null)
    {
        $this->data = $data;
        $this->totalRegistros = $totalRegistros;
        $this->totalRegistrosPaginaAtual = $totalRegistrosPaginaAtual;
    }
}
