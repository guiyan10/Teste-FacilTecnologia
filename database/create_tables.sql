-- Script para criação das tabelas do sistema de contratos
-- FacilTecnologia - Testes

-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS sistema_contratos;
USE sistema_contratos;

-- Tabela de bancos
CREATE TABLE IF NOT EXISTS Tb_banco (
    codigo INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL
);

-- Tabela de convênios
CREATE TABLE IF NOT EXISTS Tb_convenio (
    codigo INT PRIMARY KEY AUTO_INCREMENT,
    convenio VARCHAR(100) NOT NULL,
    verba VARCHAR(100) NOT NULL,
    banco INT NOT NULL,
    FOREIGN KEY (banco) REFERENCES Tb_banco(codigo)
);

-- Tabela de convênio_serviço
CREATE TABLE IF NOT EXISTS Tb_convenio_servico (
    codigo INT PRIMARY KEY AUTO_INCREMENT,
    convenio INT NOT NULL,
    servico VARCHAR(100) NOT NULL,
    FOREIGN KEY (convenio) REFERENCES Tb_convenio(codigo)
);

-- Tabela de contratos
CREATE TABLE IF NOT EXISTS Tb_contrato (
    codigo INT PRIMARY KEY AUTO_INCREMENT,
    prazo INT NOT NULL,
    valor DECIMAL(15,2) NOT NULL,
    data_inclusao DATE NOT NULL,
    convenio_servico INT NOT NULL,
    FOREIGN KEY (convenio_servico) REFERENCES Tb_convenio_servico(codigo)
);

-- Dados de exemplo para teste
INSERT INTO Tb_banco (nome) VALUES 
('Banco do Brasil'),
('Caixa Econômica Federal'),
('Bradesco'),
('Itaú');

INSERT INTO Tb_convenio (convenio, verba, banco) VALUES 
('Convênio Educação', 'Verba Federal', 1),
('Convênio Saúde', 'Verba Estadual', 2),
('Convênio Infraestrutura', 'Verba Municipal', 3),
('Convênio Tecnologia', 'Verba Federal', 4);

INSERT INTO Tb_convenio_servico (convenio, servico) VALUES 
(1, 'Serviço de Consultoria'),
(2, 'Serviço de Manutenção'),
(3, 'Serviço de Desenvolvimento'),
(4, 'Serviço de Suporte');

INSERT INTO Tb_contrato (prazo, valor, data_inclusao, convenio_servico) VALUES 
(12, 50000.00, '2024-01-15', 1),
(24, 75000.00, '2024-02-20', 2),
(18, 120000.00, '2024-03-10', 3),
(36, 200000.00, '2024-01-05', 4),
(6, 25000.00, '2024-04-12', 1),
(12, 80000.00, '2024-02-28', 2);
