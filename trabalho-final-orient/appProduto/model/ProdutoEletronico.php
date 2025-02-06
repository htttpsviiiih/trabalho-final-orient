<?php
    require_once 'Produto.php';
    
    class ProdutoEletronico extends Produto {
        private string $marca;
        private string $modelo;
    
        public function getCategoria(): string {
            return "Categoria: Eletrônicos";
        }
    

        public function getMarca(): string {
            return $this->marca;
        }
    
        public function setMarca(?string $marca): self { /// obs(o ? do lado do string permite que valores nulos sejam atribuidos)
            $this->marca = $marca;
            return $this;
        }
    

        public function getModelo(): string {
            return $this->modelo;
        }
    
        public function setModelo(?string $modelo): self {
            $this->modelo = $modelo;
            return $this;
        }

        public function getIdentificacao(): string {
            return "Marca: {$this->marca} | Modelo: {$this->modelo} |";
        }
    
    }

    