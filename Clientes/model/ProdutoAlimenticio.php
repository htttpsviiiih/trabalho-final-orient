<?php
require_once 'Produto.php';

class ProdutoAlimenticio extends Produto {
    private string $ingredientes;
    private string $validade;

    // Implementação do método abstrato da classe Produto
    public function getCategoria(): string {
        return "Alimentícios";
    }

    // Getter e Setter para ingredientes
    public function getIngredientes(): string {
        return $this->ingredientes;
    }

    public function setIngredientes(string $ingredientes): self {
        $this->ingredientes = $ingredientes;
        return $this;
    }

    // Getter e Setter para validade
    public function getValidade(): string {
        return $this->validade;
    }

    public function setValidade(string $validade): self {
        $this->validade = $validade;
        return $this;
    }
}