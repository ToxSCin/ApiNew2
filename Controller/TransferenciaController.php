<?php

namespace APINEW2\Controller;

use APINEW2\Models\ContaBancaria;
use APINEW2\Models\Transacao;
use APINEW2\DAO\ContaBancariaDAO;
use APINEW2\DAO\TransacaoDAO;

class TransferenciaController
{
    public function transferir($dados_transferencia)
    {
        // Pega os dados da transferência vindos da requisição
        $id_conta_origem = $dados_transferencia['id_conta_origem'];
        $id_conta_destino = $dados_transferencia['id_conta_destino'];
        $valor_transferencia = $dados_transferencia['valor_transferencia'];

        // Obtém as contas bancárias envolvidas na transferência
        $conta_origem = ContaBancariaDAO::buscarPorId($id_conta_origem);
        $conta_destino = ContaBancariaDAO::buscarPorId($id_conta_destino);

        // Verifica se as contas existem e se a conta de origem tem saldo suficiente para realizar a transferência
        if (!$conta_origem || !$conta_destino || $conta_origem->getSaldo() < $valor_transferencia) {
            // Retorna uma resposta de erro
            $response = array('mensagem' => 'Erro ao realizar transferência.');
            $this->setResponseAsJSON($response, false);
        } else {
            // Cria uma transação para a transferência
            $transacao = new Transacao($id_conta_origem, $id_conta_destino, $valor_transferencia);

            // Atualiza os saldos das contas envolvidas na transferência
            $conta_origem->debitar($valor_transferencia);
            $conta_destino->creditar($valor_transferencia);

            // Salva a transação e as contas bancárias no banco de dados
            $contaBancariaDAO = new ContaBancariaDAO();
            $transacaoDAO = new TransacaoDAO();

            $contaBancariaDAO->salvar($conta_origem);
            $contaBancariaDAO->salvar($conta_destino);
            $transacaoDAO->salvar($transacao);

            // Retorna uma resposta de sucesso
            $response = array('mensagem' => 'Transferência realizada com sucesso.');
            $this->setResponseAsJSON($response);
        }
    }

    protected function setResponseAsJSON($data, $request_status = true)
    {
        $response = array('response_data' => $data, 'response_successful' => $request_status);

        header("Access-Control-Allow-Origin: *");
        header("Content-type: application/json; charset=utf-8");
        header("Cache-Control: no-cache, must-revalidate");
        echo json_encode($response);
    }
}
