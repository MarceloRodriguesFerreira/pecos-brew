CREATE TABLE rampas_mostura (
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
);
