<?php

namespace APINEW2\DAO;

use APINEW2\Model\ContaBancaria;

use PDO;

class ContaBancariaDAO
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarPorId(int $id): ?ContaBancaria
    {
        $stmt = $this->pdo->prepare('SELECT * FROM contas_bancarias WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        $contaBancaria = new ContaBancaria();
        $contaBancaria->setId($result['id']);
        $contaBancaria->setNomeTitular($result['nome_titular']);
        $contaBancaria->setCpfCnpjTitular($result['cpf_cnpj_titular']);
        $contaBancaria->setBanco($result['banco']);
        $contaBancaria->setAgencia($result['agencia']);
        $contaBancaria->setNumeroConta($result['numero_conta']);
        $contaBancaria->setSaldo($result['saldo']);

        return $contaBancaria;
    }

    public function buscarPorNumeroConta(string $numeroConta): ?ContaBancaria
    {
        $stmt = $this->pdo->prepare('SELECT * FROM contas_bancarias WHERE numero_conta = :numero_conta');
        $stmt->bindValue(':numero_conta', $numeroConta, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        $contaBancaria = new ContaBancaria();
        $contaBancaria->setId($result['id']);
        $contaBancaria->setNomeTitular($result['nome_titular']);
        $contaBancaria->setCpfCnpjTitular($result['cpf_cnpj_titular']);
        $contaBancaria->setBanco($result['banco']);
        $contaBancaria->setAgencia($result['agencia']);
        $contaBancaria->setNumeroConta($result['numero_conta']);
        $contaBancaria->setSaldo($result['saldo']);

        return $contaBancaria;
    }

    public function atualizarSaldo(ContaBancaria $contaBancaria): bool
    {
        $stmt = $this->pdo->prepare('UPDATE contas_bancarias SET saldo = :saldo WHERE id = :id');
        $stmt->bindValue(':id', $contaBancaria->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':saldo', $contaBancaria->getSaldo(), PDO::PARAM_STR);

        return $stmt->execute();
    }
}
