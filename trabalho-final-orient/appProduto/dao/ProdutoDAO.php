<?php
require_once 'model/Produto.php';
require_once 'model/ProdutoEletronico.php';
require_once 'model/ProdutoAlimenticio.php';
require_once 'util/Conexao.php';

class ProdutoDAO {
    public function inserirProduto(Produto $produto) {
        $sql = "INSERT INTO produtos (id, categoria, nome, preco, codigo_de_barras, marca, modelo, ingredientes, validade)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
        $con = Conexao::getCon();
        $stm = $con->prepare($sql);
    
        if ($produto instanceof ProdutoEletronico) {
            $stm->execute([
                $produto->getId(),  // Usa o ID informado pelo usuário  mas caso o usuario informe algo diferente de um string, o programa vai usar o id do banco de dados
                'Eletrônico',
                $produto->getNome(),
                $produto->getPreco(),
                $produto->getCodigoDeBarras(),
                $produto->getMarca(),
                $produto->getModelo(),
                null,
                null
            ]);
        } elseif ($produto instanceof ProdutoAlimenticio) {
            $stm->execute([
                $produto->getId(),  // Usa o ID informado pelo usuário
                'Alimentício',
                $produto->getNome(),
                $produto->getPreco(),
                $produto->getCodigoDeBarras(),
                null,
                null,
                $produto->getIngredientes(),
                $produto->getValidade()
            ]);
        }
    }
    

    public function listarProdutos() {
        $sql = "SELECT * FROM produtos";
        $con = Conexao::getCon();
        $stm = $con->prepare($sql);
        $stm->execute();
        $registros = $stm->fetchAll(PDO::FETCH_ASSOC); // FETCH_ASSOC foi utilizado para evitar registros númericos, pq por algum motivo tava dando B.O no programa
    
        if (!$registros) {
            return [];
        }
    
        return $this->mapProdutos($registros);
    }

    public function buscarPorId(int $idProduto) {
        $sql = "SELECT * FROM produtos WHERE id = ?";
        $con = Conexao::getCon();
        $stm = $con->prepare($sql);
        $stm->execute([$idProduto]);
        $registros = $stm->fetchAll();
        $produtos = $this->mapProdutos($registros);
        return count($produtos) > 0 ? $produtos[0] : null;
    }

    public function excluirProduto(int $idProduto) {
        $sql = "DELETE FROM produtos WHERE id = ?";
        $con = Conexao::getCon();
        $stm = $con->prepare($sql);
        return $stm->execute([$idProduto]);
    }

    private function mapProdutos(array $registros) {
        $produtos = [];
        foreach ($registros as $reg) {
            if (strtolower($reg['categoria']) === 'eletronico') { // Certifica que compara corretamente
                $produto = new ProdutoEletronico();
                $produto->setMarca($reg['marca'] ?? '');
                $produto->setModelo($reg['modelo'] ?? '');
            } elseif (strtolower($reg['categoria']) === 'alimenticio') {
                $produto = new ProdutoAlimenticio();
                $produto->setIngredientes($reg['ingredientes'] ?? '');
                $produto->setValidade($reg['validade'] ?? '');
            } else {
                continue; // Se a categoria for inválida, ignora o produto
            }
            
            $produto->setId($reg['id']);
            $produto->setNome($reg['nome']);
            $produto->setPreco($reg['preco']);
            $produto->setCodigoDeBarras($reg['codigo_de_barras']);
            
            $produtos[] = $produto;
        }
        return $produtos;
    }
}    


/// auxiliar a explicação 

// A função mapProdutos recebe um array de registros ($registros), onde cada registro representa um produto com diversas propriedades. O objetivo da função é converter esses registros em objetos específicos de classes (ProdutoEletronico ou ProdutoAlimenticio), dependendo da categoria do produto.