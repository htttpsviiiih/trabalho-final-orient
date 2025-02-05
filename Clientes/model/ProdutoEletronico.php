<?php
    require_once 'Produto.php';
    
    class ProdutoEletronico extends Produto {
        private string $marca;
        private string $modelo;
    
        // Implementação do método abstrato da classe Produto
        public function getCategoria(): string {
            return "Eletrônicos";
        }
    
        // Getter e Setter para marca
        public function getMarca(): string {
            return $this->marca;
        }
    
        public function setMarca(string $marca): self {
            $this->marca = $marca;
            return $this;
        }
    
        // Getter e Setter para modelo
        public function getModelo(): string {
            return $this->modelo;
        }
    
        public function setModelo(string $modelo): self {
            $this->modelo = $modelo;
            return $this;
        }
    }

    