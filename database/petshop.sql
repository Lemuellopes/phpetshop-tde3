-- Banco de dados do Pet Shop
CREATE DATABASE IF NOT EXISTS petshop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE petshop;

-- Tabela de usuários (admin e cliente)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('admin','cliente') NOT NULL DEFAULT 'cliente'
);

-- Tabela de serviços
CREATE TABLE servicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_servico VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL DEFAULT 0
);

-- Tabela de agendamentos
CREATE TABLE agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    servico_id INT NOT NULL,
    data_agendamento DATE NOT NULL,
    horario TIME NOT NULL,
    observacao TEXT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (servico_id) REFERENCES servicos(id) ON DELETE CASCADE
);

-- Usuário admin padrão (senha: admin123)
INSERT INTO usuarios (nome, email, senha, tipo) VALUES
('Administrador', 'admin@petshop.com', '$2y$10$rxba1seB.Ja7Ne78V.vhE.A7pbzKNW3adOy6F7R30dMk4K4DlkR5q', 'admin');

-- Serviços de exemplo
INSERT INTO servicos (nome_servico, descricao, preco) VALUES
('Banho', 'Banho completo com shampoo neutro', 40.00),
('Tosa', 'Tosa higiênica ou na máquina', 60.00),
('Hidratação', 'Hidratação dos pelos', 35.00),
('Corte de unha', 'Corte e lixamento das unhas', 20.00);
