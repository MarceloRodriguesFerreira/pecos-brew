CREATE DATABASE pecosbrew;
USE pecosbrew;

-- Tabela de Fichas de Brassagem
CREATE TABLE ficha_brassagem (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome_receita VARCHAR(100) NOT NULL,
  numero_lote VARCHAR(50) NOT NULL,
  data_brassagem date NOT NULL,
  cervejeiro_responsavel VARCHAR(100) DEFAULT NULL,
  estilo VARCHAR(50) DEFAULT NULL,
  og VARCHAR(11) DEFAULT NULL,
  fg VARCHAR(11) DEFAULT NULL,
  ibu VARCHAR(9) DEFAULT NULL,
  srm VARCHAR(11) DEFAULT NULL,
  eficiencia decimal(5,2) DEFAULT NULL,
  volume_inicial decimal(5,2) DEFAULT NULL,
  volume_final decimal(5,2) DEFAULT NULL,
  tempo_fervura int(11) DEFAULT NULL,
  temperatura_fermentacao decimal(5,2) DEFAULT NULL,
  tempo_fermentacao int(11) DEFAULT NULL,
  temperatura_maturacao decimal(5,2) DEFAULT NULL,
  tempo_maturacao int(11) DEFAULT NULL,
  tipo_envase VARCHAR(50) DEFAULT NULL,
  volume_envase decimal(5,2) DEFAULT NULL,
  carbonatacao VARCHAR(50) DEFAULT NULL,
  observacoes text
) ;

/*CREATE TABLE ficha_brassagem (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_receita VARCHAR(100) NOT NULL,
    numero_lote VARCHAR(50) NOT NULL,
    data_brassagem DATE NOT NULL,
    cervejeiro_responsavel VARCHAR(100)
);*/

-- Tabela de Ingredientes Malte
CREATE TABLE ingredientes_malte (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ficha_id INT,
    nome VARCHAR(100),
    quantidade DECIMAL(10,2),
    unidade VARCHAR(2),
    tipo VARCHAR(20),
    cor  INT,
    FOREIGN KEY (ficha_id) REFERENCES ficha_brassagem(id)
);

-- Tabela de Ingredientes Lupulo
CREATE TABLE ingredientes_lupulo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ficha_id INT,
    nome VARCHAR(100),
    idx_alfa_acido DECIMAL(10,2),
    quantidade DECIMAL(10,2),
    tempo_adicao int,
    uso VARCHAR(15),
    FOREIGN KEY (ficha_id) REFERENCES ficha_brassagem(id)
);
 
/*-- Tabela de Levedura
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
);*/

-- Tabela de rampas de temperatura da mostura
CREATE TABLE rampas_mostura (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ficha_id INT NOT NULL,
    temperatura DECIMAL(5,2) NOT NULL,
    tempo INT NOT NULL,
    descricao VARCHAR(255) null,
    KEY ficha_id (ficha_id),
    CONSTRAINT rampas_mostura_ibfk_1 FOREIGN KEY (ficha_id) REFERENCES ficha_brassagem (id) ON DELETE CASCADE
);

-- Tabela de Ingredientes Malte
CREATE TABLE ingredientes_malte (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ficha_id INT,
    nome VARCHAR(100),
    quantidade DECIMAL(10,2),
    unidade VARCHAR(2),
    tipo VARCHAR(20),
    cor  INT,
    FOREIGN KEY (ficha_id) REFERENCES ficha_brassagem(id)
);