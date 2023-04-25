<?php

namespace APINEW2\Models;

class Transacao
{
    private $id;
    private $id_conta_origem;
    private $id_conta_destino;
    private $valor;

    public function __construct($id_conta_origem, $id_conta_destino, $valor)
    {
        $this->id_conta_origem = $id_conta_origem;
        $this->id_conta_destino = $id_conta_destino;
        $this->valor = $valor;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdContaOrigem()
    {
        return $this->id_conta_origem;
    }

    public function getIdContaDestino()
    {
        return $this->id_conta_destino;
    }

    public function getValor()
    {
        return $this->valor;
    }
}
