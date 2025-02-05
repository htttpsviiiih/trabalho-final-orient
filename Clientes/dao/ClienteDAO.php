<?php
require_once("model/Produto.php");
require_once("model/ProdutoEletronico.php");
require_once("model/ProdutoAlimenticio.php");
require_once("util/Conexao.php");

class ProdutoDAO {

    // Função para inserir um produto no banco de dados
    public function inserirProduto(Produto $produto){
        try {
            $sql = "INSERT INTO produtos (nome, descricao, preco, categoria) VALUES (?, ?, ?, ?)";
            $con = Conexao::getConn();
            $stm = $con->prepare($sql);

            if ($produto instanceof ProdutoEletronico) {
                // Inserir produto eletrônico
                $stm->execute([
                    $produto->getNome(),
                    $produto->getDescricao(),
                    $produto->getPreco(),
                    'eletronico'
                ]);
            } elseif ($produto instanceof ProdutoAlimenticio) {
                // Inserir produto alimentício
                $stm->execute([
                    $produto->getNome(),
                    $produto->getDescricao(),
                    $produto->getPreco(),
                    'alimenticio'
                ]);
            }
        } catch (Exception $e) {
            echo "Erro ao inserir produto: " . $e->getMessage();
        }
    }

    // Função para listar todos os produtos no banco de dados
    public function listarProdutos(){
        $sql = "SELECT * FROM produtos";
        $con = Conexao::getConn();
        $stm = $con->prepare($sql);
        $stm->execute();
        $registros = $stm->fetchAll();
        return $this->mapProdutos($registros);
    }

    // Função para buscar um produto pelo ID
    public function buscarPorId($id){
        $sql = "SELECT * FROM produtos WHERE id = ?";
        $con = Conexao::getConn();
        $stm = $con->prepare($sql);
        $stm->execute([$id]);
        $registros = $stm->fetchAll();
        $produto = $this->mapProdutos($registros);
        return count($produto) ? $produto[0] : null;
    }

    // Função para excluir um produto
    public function excluirProduto($id){
        $sql = "DELETE FROM produtos WHERE id = ?";
        $con = Conexao::getConn();
        $stm = $con->prepare($sql);
        return $stm->execute([$id]);
    }

    // Função para mapear os resultados de produtos da consulta para objetos de produto
    private function mapProdutos(array $registros){
        $produtos = array();
        foreach($registros as $reg){
            $produto = null;
            if ($reg['categoria'] == 'eletronico') {
                $produto = new ProdutoEletronico();
                $produto->setMarca($reg['marca']);
            } elseif ($reg['categoria'] == 'alimenticio') {
                $produto = new ProdutoAlimenticio();
                $produto->setDataValidade($reg['data_validade']);
            }

            $produto->setId($reg['id']);
            $produto->setNome($reg['nome']);
            $produto->setDescricao($reg['descricao']);
            $produto->setPreco($reg['preco']);
            array_push($produtos, $produto);
        }
        return $produtos;
    }
}

