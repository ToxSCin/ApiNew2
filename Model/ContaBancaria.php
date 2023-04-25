<?php

namespace APINEW2\Model;

class ContaBancaria
{
    private $id;
    private $nomeTitular;
    private $cpfCnpjTitular;
    private $banco;
    private $agencia;
    private $numeroConta;
    private $saldo;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNomeTitular(): string
    {
        return $this->nomeTitular;
    }

    public function setNomeTitular(string $nomeTitular): void
    {
        $this->nomeTitular = $nomeTitular;
    }

    public function getCpfCnpjTitular(): string
    {
        return $this->cpfCnpjTitular;
    }

    public function setCpfCnpjTitular(string $cpfCnpjTitular): void
    {
        $this->cpfCnpjTitular = $cpfCnpjTitular;
    }

    public function getBanco(): string
    {
        return $this->banco;
    }

    public function setBanco(string $banco): void
    {
        $this->banco = $banco;
    }

    public function getAgencia(): string
    {
        return $this->agencia;
    }

    public function setAgencia(string $agencia): void
    {
        $this->agencia = $agencia;
    }

    public function getNumeroConta(): string
    {
        return $this->numeroConta;
    }

    public function setNumeroConta(string $numeroConta): void
    {
        $this->numeroConta = $numeroConta;
    }

    public function getSaldo(): float
    {
        return $this->saldo;
    }

    public function setSaldo(float $saldo): void
    {
        $this->saldo = $saldo;
    }

    public function creditar(float $valor): void
    {
        $this->saldo += $valor;
    }

    public function debitar(float $valor): bool
    {
        if ($this->saldo < $valor) {
            return false;
        }

        $this->saldo -= $valor;
        return true;
    }

    public function salvar()
    {
        $db = new \PDO('mysql:host=localhost;dbname=nome_do_banco', 'usuario', 'senha');
    
        if ($this->getId()) {
            $stmt = $db->prepare('UPDATE contas_bancarias SET nome_titular = ?, cpf_cnpj_titular = ?, banco = ?, agencia = ?, numero_conta = ?, saldo = ? WHERE id = ?');
            $stmt->execute([$this->getNomeTitular(), $this->getCpfCnpjTitular(), $this->getBanco(), $this->getAgencia(), $this->getNumeroConta(), $this->getSaldo(), $this->getId()]);
        } else {
            $stmt = $db->prepare('INSERT INTO contas_bancarias (nome_titular, cpf_cnpj_titular, banco, agencia, numero_conta, saldo) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([$this->getNomeTitular(), $this->getCpfCnpjTitular(), $this->getBanco(), $this->getAgencia(), $this->getNumeroConta(), $this->getSaldo()]);
            $this->setId($db->lastInsertId());
        }
    }
    
}
