/*CREATE TABLE rampas_mostura (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ficha_id INT NOT NULL,
    temperatura DECIMAL(5,2) NOT NULL,
    tempo INT NOT NULL,
    descricao VARCHAR(255),
    hora_inicial TIME,
    hora_final TIME,
    temperatura_min DECIMAL(5,2),
    temperatura_max DECIMAL(5,2),
    FOREIGN KEY (ficha_id) REFERENCES ficha_brassagem(id) ON DELETE CASCADE
);*/

-- Tabela de rampas de temperatura da mostura
CREATE TABLE rampas_mostura (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ficha_id INT NOT NULL,
    temperatura DECIMAL(5,2) NOT NULL,
    tempo INT NOT NULL,
    descricao VARCHAR(255) null,
    KEY `ficha_id` (`ficha_id`),
    CONSTRAINT `rampas_mostura_ibfk_1` FOREIGN KEY (`ficha_id`) REFERENCES `ficha_brassagem` (`id`) ON DELETE CASCADE
)


-- Tabela de Ingredientes Malte
CREATE TABLE ingredientes_malte (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ficha_id INT,
    nome VARCHAR(100),
    quantidade DECIMAL(10,2),
    unidade VARCHAR(20),
    FOREIGN KEY (ficha_id) REFERENCES ficha_brassagem(id)
);
