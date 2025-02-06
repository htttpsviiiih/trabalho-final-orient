<?php
require_once 'Produto.php';

class ProdutoAlimenticio extends Produto {
    private string $ingredientes;
    private string $validade;

    public function getCategoria(): string {
        return "Categoria: Alimentícios";
    }

 
    public function getIngredientes(): string {
        return $this->ingredientes;
    }

    public function setIngredientes(?string $ingredientes): self {
        $this->ingredientes = $ingredientes;
        return $this;
    }

   
    public function getValidade(): string {
        return $this->validade;
    }

    public function setValidade(?string $validade): self {
        $this->validade = $validade;
        return $this;
    }

    public function getIdentificacao(): string {
        return "Ingredientes:  {$this->ingredientes}\n Validade:  {$this->validade}";
    }
}