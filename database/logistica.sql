CREATE DATABASE IF NOT EXISTS logistica CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE logistica;

CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) NOT NULL UNIQUE,
    nome VARCHAR(120) NOT NULL,
    descricao TEXT NULL,
    peso DECIMAL(10,2) NOT NULL DEFAULT 0,
    valor DECIMAL(10,2) NOT NULL DEFAULT 0,
    quantidade INT NOT NULL DEFAULT 0,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS enderecos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    identificacao VARCHAR(120) NOT NULL,
    tipo ENUM('origem','destino','ambos') NOT NULL DEFAULT 'ambos',
    cep VARCHAR(12) NOT NULL,
    rua VARCHAR(150) NOT NULL,
    numero VARCHAR(20) NOT NULL,
    complemento VARCHAR(100) NULL,
    bairro VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    estado CHAR(2) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS transportadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    documento VARCHAR(30) NOT NULL,
    telefone VARCHAR(30) NULL,
    email VARCHAR(120) NULL,
    veiculo VARCHAR(80) NULL,
    placa VARCHAR(10) NULL,
    status ENUM('ativo','inativo') NOT NULL DEFAULT 'ativo',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS fretes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_frete DATE NOT NULL,
    origem_id INT NOT NULL,
    destino_id INT NOT NULL,
    transportador_id INT NOT NULL,
    status ENUM('Pendente','Em transporte','Concluído','Cancelado') NOT NULL DEFAULT 'Pendente',
    observacoes TEXT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_frete_origem FOREIGN KEY (origem_id) REFERENCES enderecos(id),
    CONSTRAINT fk_frete_destino FOREIGN KEY (destino_id) REFERENCES enderecos(id),
    CONSTRAINT fk_frete_transportador FOREIGN KEY (transportador_id) REFERENCES transportadores(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS frete_produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    frete_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    CONSTRAINT fk_fp_frete FOREIGN KEY (frete_id) REFERENCES fretes(id) ON DELETE CASCADE,
    CONSTRAINT fk_fp_produto FOREIGN KEY (produto_id) REFERENCES produtos(id)
) ENGINE=InnoDB;
