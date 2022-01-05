<?php

namespace App\Controllers;

use App\Lib\ConversorMonetario;
use App\Lib\Sessao;
use App\Lib\Paginacao;
use App\Models\DAO\ProdutoDAO;
use App\Models\Entidades\Produto;
use App\Models\Validacao\ProdutoValidador;

class ProdutoController extends Controller
{
    public function index($params)
    {
        $produtoDAO = new ProdutoDAO();

        $paginaSelecionada  = isset($_GET['paginaSelecionada']) ? $_GET['paginaSelecionada'] : 1;
        $totalPorPagina     = 6;

        if(isset($_GET['buscaProduto'])){

            $listaProdutos      = $produtoDAO->buscaComPaginacao($_GET['buscaProduto'], $totalPorPagina, $paginaSelecionada);

            $paginacao = new Paginacao($listaProdutos);
            
            self::setViewParam('buscaProduto', $_GET['buscaProduto']);
            self::setViewParam('paginacao', $paginacao->criandoLink($_GET['buscaProduto']));
            self::setViewParam('queryString', Paginacao::criandoQuerystring($_GET['paginaSelecionada'], $_GET['buscaProduto']));

            self::setViewParam('listaProdutos'  , $listaProdutos['resultado']);

        }

        $this->render('/produto/index');

        Sessao::limpaMensagem();
    }

    public function cadastro()
    {
        $this->render('/produto/cadastro');

        Sessao::limpaFormulario();
        Sessao::limpaMensagem();
        Sessao::limpaErro();
    }

    public function salvar()
    {
        $Produto = new Produto();
        $Produto->setNome($_POST['nome']);
        $Produto->setStatus($_POST['status']);
        $Produto->setPreco(ConversorMonetario::realParaDolar($_POST['preco']));
        $Produto->setUnidade($_POST['unidade']);
        $Produto->setEan($_POST['ean']);
        $Produto->setDescricao($_POST['descricao']);

        Sessao::gravaFormulario($_POST);

        $produtoValidador = new ProdutoValidador();
        $resultadoValidacao = $produtoValidador->validar($Produto);

        if($resultadoValidacao->getErros()){
            Sessao::gravaErro($resultadoValidacao->getErros());
            $this->redirect('/produto/cadastro');
        }

        $produtoDAO = new ProdutoDAO();

        if($produtoDAO->validaEan($Produto->getEan()))
        {
            Sessao::gravaErro(['Código EAN já existe.']);
            $this->redirect('/produto/cadastro');
        }

        $produtoDAO->salvar($Produto);
        
        Sessao::limpaFormulario();
        Sessao::limpaMensagem();
        Sessao::limpaErro();

        $this->redirect('/produto');
      
    }
    
    public function edicao($params)
    {
        $id = $params[0];

        $produtoDAO = new ProdutoDAO();

        $produto = $produtoDAO->listar($id);

        if(!$produto){
            Sessao::gravaMensagem("Produto inexistente");
            $this->redirect('/produto');
        }

        self::setViewParam('produto',$produto);
        self::setViewParam('queryString', Paginacao::criandoQuerystring($_GET['paginaSelecionada'], $_GET['buscaProduto']));

        $this->render('/produto/editar');

        Sessao::limpaMensagem();
        Sessao::limpaErro();

    }

    public function atualizar()
    {

        $Produto = new Produto();
        $Produto->setId($_POST['id']);
        $Produto->setNome($_POST['nome']);
        $Produto->setStatus($_POST['status']);
        $Produto->setPreco(ConversorMonetario::realParaDolar($_POST['preco']));
        $Produto->setUnidade($_POST['unidade']);
        $Produto->setEan($_POST['ean']);
        $Produto->setDescricao($_POST['descricao']);

        Sessao::gravaFormulario($_POST);

        $produtoValidador = new ProdutoValidador();
        $resultadoValidacao = $produtoValidador->validar($Produto);

        if($resultadoValidacao->getErros()){
            Sessao::gravaErro($resultadoValidacao->getErros());
            $this->redirect('/produto/edicao/'.$_POST['id']);
        }

        $produtoDAO = new ProdutoDAO();

        $ProdutoSelecionado = $produtoDAO->listar($Produto->getId());

        if($produtoDAO->validaEan($Produto->getEan()) &&
            ($ProdutoSelecionado->getEan() != $Produto->getEan()))
        {
            Sessao::gravaErro(['Código EAN já existe.']);
            $this->redirect('/produto/edicao/'.$_POST['id'].'?buscaProduto='.$_GET['buscaProduto'].'&paginaSelecionada='.$_GET['paginaSelecionada']);
        }
      
        $produtoDAO->atualizar($Produto);

        Sessao::limpaFormulario();
        Sessao::limpaMensagem();
        Sessao::limpaErro();

        $this->redirect('/produto/?buscaProduto='.$_GET['buscaProduto']);

    }
    
    public function exclusao($params)
    {
        $id = $params[0];

        $produtoDAO = new ProdutoDAO();

        $produto = $produtoDAO->listar($id);

        if(!$produto){
            Sessao::gravaMensagem("Produto inexistente");
            $this->redirect('/produto');
        }

        self::setViewParam('produto',$produto);
        self::setViewParam('queryString', Paginacao::criandoQuerystring($_GET['paginaSelecionada'], $_GET['buscaProduto']));

        $this->render('/produto/exclusao');

        Sessao::limpaMensagem();

    }

    public function excluir()
    {
        $Produto = new Produto();
        $Produto->setId($_POST['id']);

        $produtoDAO = new ProdutoDAO();

        if(!$produtoDAO->excluir($Produto)){
            Sessao::gravaMensagem("Produto inexistente");
            $this->redirect('/produto');
        }

        Sessao::gravaMensagem("Produto excluido com sucesso!");

        $this->redirect('/produto/');

    }
}