<?php
namespace APINEW2\DAO;

use APINEW2\Models\Transacao;
use APINEW2\Util\Database;

class TransacaoDAO {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function salvar(Transacao $transacao) {
        $query = "INSERT INTO transacoes (id_conta_origem, id_conta_destino, valor) VALUES (:id_conta_origem, :id_conta_destino, :valor)";
        $params = [
            ':id_conta_origem' => $transacao->getIdContaOrigem(),
            ':id_conta_destino' => $transacao->getIdContaDestino(),
            ':valor' => $transacao->getValor()
        ];
        $this->db->execute($query, $params);
    }

    public function buscarPorId($id) {
        $query = "SELECT * FROM transacoes WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->query($query, $params);

        if (!$result) {
            return null;
        }

        $transacao = new Transacao($result['id_conta_origem'], $result['id_conta_destino'], $result['valor']);
        $transacao->setId($result['id']);
        return $transacao;
    }
}
