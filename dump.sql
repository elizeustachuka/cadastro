CREATE TABLE produto
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(200) NOT NULL,
    status CHAR(1) NOT NULL DEFAULT 1,
    preco DOUBLE(10,2) NOT NULL,
    unidade VARCHAR(30) NOT NULL,
    ean BIGINT NOT NULL,
    descricao TEXT,
    dataCadastro DATETIME DEFAULT NOW()
);