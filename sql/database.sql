CREATE DATABASE pecosbrew;
USE pecosbrew;

-- Tabela de Fichas de Brassagem
CREATE TABLE ficha_brassagem (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_receita VARCHAR(100) NOT NULL,
    numero_lote VARCHAR(50) NOT NULL,
    data_brassagem DATE NOT NULL,
    cervejeiro_responsavel VARCHAR(100)
);

-- Tabela de Ingredientes Malte
CREATE TABLE ingredientes_malte (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ficha_id INT,
    nome VARCHAR(100),
    quantidade DECIMAL(10,2),
    unidade VARCHAR(20),
    FOREIGN KEY (ficha_id) REFERENCES ficha_brassagem(id)
);

-- Tabela de Ingredientes Lupulo
CREATE TABLE ingredientes_lupulo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ficha_id INT,
    nome VARCHAR(100),
    quantidade DECIMAL(10,2),
    tempo_adicao VARCHAR(50),
    FOREIGN KEY (ficha_id) REFERENCES ficha_brassagem(id)
);

-- Tabela de Levedura
CREATE TABLE ingredientes_levedura (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ficha_id INT,
    nome VARCHAR(100),
    quantidade DECIMAL(10,2),
    FOREIGN KEY (ficha_id) REFERENCES ficha_brassagem(id)
);

-- Tabela de Informações Adicionais
CREATE TABLE informacoes_receita (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ficha_id INT,
    og DECIMAL(5,3),
    fg DECIMAL(5,3),
    ibu DECIMAL(5,2),
    ebc DECIMAL(5,2),
    observacoes TEXT,
    FOREIGN KEY (ficha_id) REFERENCES ficha_brassagem(id)
);
