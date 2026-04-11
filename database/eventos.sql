-- Este script prepara o ambiente da aula: cria o banco, a tabela principal e alguns registros de exemplo.
CREATE DATABASE IF NOT EXISTS mvc_eventos CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE mvc_eventos;

-- A tabela guarda os campos usados pelo CRUD e um timestamp automatico para registrar a criacao.
CREATE TABLE IF NOT EXISTS eventos_corrida (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    data_evento DATE NOT NULL,
    distancia VARCHAR(20) NOT NULL,
    status_evento VARCHAR(30) NOT NULL,
    observacoes TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Estes dados iniciais facilitam os testes da listagem e da edicao logo apos importar o script.
INSERT INTO eventos_corrida (nome, cidade, data_evento, distancia, status_evento, observacoes) VALUES
('Corrida da Primavera', 'São Paulo', '2026-09-12', '5 km', 'Planejado', 'Evento ideal para iniciantes.'),
('Desafio 10K Centro', 'Campinas', '2026-07-20', '10 km', 'Inscrito', 'Percurso urbano com hidratação a cada 2 km.'),
('Meia Maratona da Serra', 'Belo Horizonte', '2026-08-03', '21 km', 'Concluído', 'Prova com altimetria mais exigente.');
