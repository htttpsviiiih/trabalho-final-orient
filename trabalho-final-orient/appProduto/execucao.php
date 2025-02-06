<?php
require_once 'model/ProdutoEletronico.php';
require_once 'model/ProdutoAlimenticio.php';
require_once './dao/ProdutoDAO.php';
require_once 'util/Conexao.php';

function listaProdutos() {
    $produtoDao = new ProdutoDAO();
    $produtos = $produtoDao->listarProdutos();
    foreach ($produtos as $p) {
        if ($p instanceof ProdutoEletronico) {
            printf("ID: %d | %s | Nome: %s | Marca: %s | Modelo: %s | Preço: %.2f | Codigo: %s\n",
                $p->getId(), $p->getCategoria(), $p->getNome(), $p->getMarca(), $p->getModelo(),$p->getPreco(), $p->getCodigoDeBarras());
        } else {
            printf("ID: %d | %s | Nome: %s | Ingrediente Principal: %s, | Validade: %s | Preço: %.2f | Código: %s\n",
                $p->getId(), $p->getCategoria(), $p->getNome(), $p->getIngredientes(), $p->getValidade(),$p->getPreco(), $p->getCodigoDeBarras());
        }
    }
}

do {
    echo "\n-----CADASTRO DE PRODUTOS-----\n
    1- CADASTRAR PRODUTO ELETRÔNICO\n
    2- CADASTRAR PRODUTO ALIMENTÍCIO\n
    3- LISTAR PRODUTOS\n
    4- BUSCAR PRODUTO\n
    5- EXCLUIR PRODUTO\n
    0- SAIR \n\n";
    
    $opcao = readline("Informe a opção:");
    
    switch ($opcao) {
        case 1:
            
            $produto = new ProdutoEletronico();
            $produto->setId(intval(readline("ID do Produto: ")));  
            $produto->setNome(readline("Nome do Produto: "));
            $produto->setMarca(readline("Marca: "));
            $produto->setModelo(readline("Modelo:"));
            $produto->setCodigoDeBarras(readline("Código de Barras: "));
            $produto->setPreco(floatval(readline("Preço: ")));
            
            $produtoDao = new ProdutoDAO();
            $produtoDao->inserirProduto($produto);
            echo "Produto Eletrônico cadastrado com sucesso!\n";
            break;

        case 2:
            
            $produto = new ProdutoAlimenticio();
            $produto->setId(intval(readline("ID do Produto: ")));  
            $produto->setNome(readline("Nome do Produto: "));
            $produto->setIngredientes(readline("Ingrediente Principal: "));
            $produto->setValidade(readline("Validade (ex: 12/12/2025): "));
            $produto->setCodigoDeBarras(readline("Código de Barras: "));
            $produto->setPreco(floatval(readline("Preço: ")));
            
            $produtoDao = new ProdutoDAO();
            $produtoDao->inserirProduto($produto);
            echo "Produto Alimentício cadastrado com sucesso!\n";
            break;

        case 3:
            
            listaProdutos();
            break;

        case 4:
            listaProdutos();
            $id = readline("Digite o ID do produto: ");
            $produtoDao = new ProdutoDAO();
            $p = $produtoDao->buscarPorId($id);
            
            if ($p) {
                if ($p instanceof ProdutoEletronico) {
                    printf("ID: %d | Categoria: %s | Nome: %s | Marca: %s | Modelo: %s | Preço: %.2f | Código: %s\n",
                        $p->getId(), $p->getCategoria(), $p->getNome(), $p->getMarca(), $p->getModelo(), $p->getPreco(), $p->getCodigoDeBarras());
                } else {
                    printf("ID: %d | Categoria: %s | Nome: %s | Ingredientes: %s | Validade: %s | Preço: %.2f | Código: %s\n",
                        $p->getId(), $p->getCategoria(), $p->getNome(), $p->getIngredientes(), $p->getValidade(), $p->getPreco(), $p->getCodigoDeBarras());
                }
            } else {
                echo "\nProduto com ID " . $id . " não encontrado!\n";
            }
            break;

        case 5:
            listaProdutos();
            $id = readline("Digite o ID do produto a ser excluído: ");
            $produtoDao = new ProdutoDAO();
            $p = $produtoDao->buscarPorId($id);
            if ($p != null) {
                if ($produtoDao->excluirProduto($p->getId())) {
                    echo "\nProduto excluído com sucesso!\n";
                } else {
                    echo "\nErro ao excluir produto!\n";
                }
            } else {
                echo "\nProduto com id " . $id . " não encontrado!\n";
            }
            break;

        case 0:
            echo "\nPrograma encerrado\n";
            break;

        default:
            echo "\nOpção Inválida\n";
            break;
    }
} while ($opcao != 0);

