<?php

namespace APINEW2\Models;

use APINEW2\Util\Database;


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

    public function salvar()
    {
        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare('INSERT INTO transacoes (id_conta_origem, id_conta_destino, valor) VALUES (:id_conta_origem, :id_conta_destino, :valor)');
        $stmt->bindValue(':id_conta_origem', $this->id_conta_origem);
        $stmt->bindValue(':id_conta_destino', $this->id_conta_destino);
        $stmt->bindValue(':valor', $this->valor);
        $stmt->execute();

        $this->id = $conn->lastInsertId();
    }

    public function buscarPorId($id)
    {
        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare('SELECT * FROM transacoes WHERE id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result) {
            $transacao = new Transacao($result['id_conta_origem'], $result['id_conta_destino'], $result['valor']);
            $transacao->setId($result['id']);
            return $transacao;
        } else {
            return null;
        }
    }
}
