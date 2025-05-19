CREATE TABLE alunos (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL,
	tipo ENUM('aluno', 'admin') DEFAULT 'aluno'
);

CREATE TABLE cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE aluno_curso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_aluno INT NOT NULL,
    id_curso INT NOT NULL,
    data_matricula DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(id_aluno, id_curso), -- evita matrícula duplicada
    FOREIGN KEY (id_aluno) REFERENCES alunos(id),
    FOREIGN KEY (id_curso) REFERENCES cursos(id)
);


CREATE TABLE aulas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_curso INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    video_url VARCHAR(255),
    ordem INT DEFAULT 0,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_curso) REFERENCES cursos(id)
);



CREATE TABLE progresso_aula (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_aluno INT NOT NULL,
    id_aula INT NOT NULL,
    assistido_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(id_aluno, id_aula),
    FOREIGN KEY (id_aluno) REFERENCES alunos(id),
    FOREIGN KEY (id_aula) REFERENCES aulas(id)
);


-- Dropar o banco se já existir
DROP DATABASE IF EXISTS ead;

-- Criar o banco com charset utf8mb4
CREATE DATABASE ead
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

-- Usar o banco
USE ead;

-- Tabela de alunos
CREATE TABLE alunos (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('aluno', 'admin') DEFAULT 'aluno'
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Tabela de cursos
CREATE TABLE cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Tabela de relacionamento aluno-curso
CREATE TABLE aluno_curso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_aluno INT NOT NULL,
    id_curso INT NOT NULL,
    data_matricula DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(id_aluno, id_curso),
    FOREIGN KEY (id_aluno) REFERENCES alunos(id),
    FOREIGN KEY (id_curso) REFERENCES cursos(id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Tabela de aulas
CREATE TABLE aulas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_curso INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    video_url VARCHAR(255),
    ordem INT DEFAULT 0,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_curso) REFERENCES cursos(id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;


-- Tabela de progresso da aula
CREATE TABLE progresso_aula (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_aluno INT NOT NULL,
    id_aula INT NOT NULL,
    assistido_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(id_aluno, id_aula),
    FOREIGN KEY (id_aluno) REFERENCES alunos(id),
    FOREIGN KEY (id_aula) REFERENCES aulas(id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'PHP do zero ao avançado', 'Você irá aprender tudo sobre PHP do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Javascript do zero ao avançado', 'Você irá aprender tudo sobre Javascript do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'C# do zero ao avançado', 'Você irá aprender tudo sobre C# do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Python do zero ao avançado', 'Você irá aprender tudo sobre Python do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'HTML5 do zero ao avançado', 'Você irá aprender tudo sobre HTML5 do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'CSS3 do zero ao avançado', 'Você irá aprender tudo sobre CSS3 do zero até se tornar um profissional', current_timestamp());