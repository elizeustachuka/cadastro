<?php

namespace App\Models\DAO;

use App\Models\Entidades\Produto;
use App\Models\Paginacao;

class ProdutoDAO extends BaseDAO
{
    public  function buscaComPaginacao($buscaProduto, $totalPorPagina, $paginaSelecionada)
    {

        $paginaSelecionada = (!$paginaSelecionada) ? 1 : $paginaSelecionada;

        $inicio = (($paginaSelecionada - 1) * $totalPorPagina);

        $whereBusca = " WHERE nome 
                                LIKE '%$buscaProduto%' OR descricao 
                                LIKE '%$buscaProduto%' OR ean = '$buscaProduto'
                         ";

        $resultadoTotal = $this->select(
            "SELECT count(*) as total FROM produto $whereBusca "
        );

        $resultado = $this->select(
            "SELECT * FROM produto as produto $whereBusca LIMIT $inicio,$totalPorPagina"
        );
        
        $totalLinhas      = $resultadoTotal->fetch()['total'];

        return ['paginaSelecionada' => $paginaSelecionada,
                'totalPorPagina'    => $totalPorPagina,
                'totalLinhas'       => $totalLinhas,
                'resultado'         => $resultado->fetchAll(\PDO::FETCH_CLASS, Produto::class)];

    }
    public  function validaEan($ean)
    {
        if($ean) {
            $resultado = $this->select(
                "SELECT count(*) as total FROM produto WHERE ean = '$ean'"
            );

            return $resultado->fetch()['total'];
        }else{
           return false;
        }

        return false;
    }
    public  function listar($id = null)
    {
        if($id) {
            $resultado = $this->select(
                "SELECT * FROM produto WHERE id = $id"
            );

            return $resultado->fetchObject(Produto::class);
        }else{
            $resultado = $this->select(
                'SELECT * FROM produto'
            );
            return $resultado->fetchAll(\PDO::FETCH_CLASS, Produto::class);
        }

        return false;
    }

    public  function salvar(Produto $produto) 
    {
        try {

            $nome           = $produto->getNome();
            $status         = $produto->getStatus();
            $preco          = $produto->getPreco();
            $unidade        = $produto->getUnidade();
            $ean            = $produto->getEan();
            $descricao      = $produto->getDescricao();

            return $this->insert(
                'produto',
                ":nome,:status,:preco,:unidade,:ean,:descricao",
                [
                    ':nome'=>$nome,
                    ':status'=>$status,
                    ':preco'=>$preco,
                    ':unidade'=>$unidade,
                    ':ean'=>$ean,
                    ':descricao'=>$descricao
                ]
            );

        }catch (\Exception $e){
            throw new \Exception("Erro na gravação de dados." . $e->getMessage(), 500);
        }
    }

    public  function atualizar(Produto $produto) 
    {
        try {

            $id             = $produto->getId();
            $nome           = $produto->getNome();
            $status         = $produto->getStatus();
            $preco          = $produto->getPreco();
            $unidade        = $produto->getUnidade();
            $ean            = $produto->getEan();
            $descricao      = $produto->getDescricao();

            return $this->update(
                'produto',
                "nome = :nome,status = :status, preco = :preco, unidade = :unidade, ean = :ean, descricao = :descricao",
                [
                    ':id'=>$id,
                    ':nome'=>$nome,
                    ':status'=>$status,
                    ':preco'=>$preco,
                    ':unidade'=>$unidade,
                    ':ean'=>$ean,
                    ':descricao'=>$descricao,
                ],
                "id = :id"
            );

        }catch (\Exception $e){
            throw new \Exception("Erro na gravação de dados.", 500);
        }
    }

    public function excluir(Produto $produto)
    {
        try {
            $id = $produto->getId();

            return $this->delete('produto',"id = $id");

        }catch (Exception $e){

            throw new \Exception("Erro ao deletar", 500);
        }
    }
}