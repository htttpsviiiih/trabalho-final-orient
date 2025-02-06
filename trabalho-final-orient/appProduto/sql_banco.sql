-- Criação da tabela de produtos
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,  
    nome VARCHAR(255) NOT NULL,         
    descricao TEXT,                     
    preco DECIMAL(10, 2) NOT NULL,      
    categoria ENUM('eletronico', 'alimenticio') NOT NULL, 
    marca VARCHAR(255),                 
    data_validade DATE                 
);



