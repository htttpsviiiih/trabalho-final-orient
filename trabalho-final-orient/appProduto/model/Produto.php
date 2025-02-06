<?php
abstract class Produto {
    protected int $id;
    protected string $nome;
    protected float $preco;
    protected string $codigoDeBarras;

    
    abstract public function getCategoria(): string;
    abstract public function getIdentificacao(): string;

    
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    
    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome): self {
        $this->nome = $nome;
        return $this;
    }

    public function getPreco(): float {
        return $this->preco;
    }

    public function setPreco(float $preco): self {
        $this->preco = $preco;
        return $this;
    }


    public function getCodigoDeBarras(): string {
        return $this->codigoDeBarras;
    }

    public function setCodigoDeBarras(string $codigoDeBarras): self {
        $this->codigoDeBarras = $codigoDeBarras;
        return $this;
    }
}
