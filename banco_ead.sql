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



INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Java do zero ao avançado', 'Você irá aprender tudo sobre Java do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'React do zero ao avançado', 'Você irá aprender tudo sobre React do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Angular do zero ao avançado', 'Você irá aprender tudo sobre Angular do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Vue.js do zero ao avançado', 'Você irá aprender tudo sobre Vue.js do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Node.js do zero ao avançado', 'Você irá aprender tudo sobre Node.js do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Laravel do zero ao avançado', 'Você irá aprender tudo sobre Laravel do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'MySQL do zero ao avançado', 'Você irá aprender tudo sobre MySQL do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'PostgreSQL do zero ao avançado', 'Você irá aprender tudo sobre PostgreSQL do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Ruby on Rails do zero ao avançado', 'Você irá aprender tudo sobre Ruby on Rails do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Kotlin do zero ao avançado', 'Você irá aprender tudo sobre Kotlin do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Swift do zero ao avançado', 'Você irá aprender tudo sobre Swift do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'TypeScript do zero ao avançado', 'Você irá aprender tudo sobre TypeScript do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Flutter do zero ao avançado', 'Você irá aprender tudo sobre Flutter do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Dart do zero ao avançado', 'Você irá aprender tudo sobre Dart do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'C++ do zero ao avançado', 'Você irá aprender tudo sobre C++ do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Unity com C# do zero ao avançado', 'Você irá aprender tudo sobre desenvolvimento de jogos com Unity e C# do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Android Studio do zero ao avançado', 'Você irá aprender tudo sobre desenvolvimento de apps no Android Studio do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'DevOps do zero ao avançado', 'Você irá aprender tudo sobre DevOps do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Git e GitHub do zero ao avançado', 'Você irá aprender tudo sobre controle de versão com Git e GitHub do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Segurança da Informação do zero ao avançado', 'Você irá aprender tudo sobre Segurança da Informação do zero até se tornar um profissional', current_timestamp());
INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Design Gráfico do zero ao avançado', 'Você irá aprender tudo sobre Design Gráfico do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'UI/UX Design do zero ao avançado', 'Você irá aprender tudo sobre UI/UX Design do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Inteligência Artificial do zero ao avançado', 'Você irá aprender tudo sobre Inteligência Artificial do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Machine Learning do zero ao avançado', 'Você irá aprender tudo sobre Machine Learning do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Data Science do zero ao avançado', 'Você irá aprender tudo sobre Ciência de Dados do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Power BI do zero ao avançado', 'Você irá aprender tudo sobre Power BI do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Excel Avançado do zero ao avançado', 'Você irá aprender tudo sobre Excel do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Marketing Digital do zero ao avançado', 'Você irá aprender tudo sobre Marketing Digital do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Google Ads do zero ao avançado', 'Você irá aprender tudo sobre Google Ads do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Facebook Ads do zero ao avançado', 'Você irá aprender tudo sobre Facebook Ads do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Copywriting do zero ao avançado', 'Você irá aprender tudo sobre Copywriting do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'SEO do zero ao avançado', 'Você irá aprender tudo sobre SEO do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'E-commerce do zero ao avançado', 'Você irá aprender tudo sobre E-commerce do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Criação de Sites com WordPress', 'Você irá aprender tudo sobre WordPress do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Fotografia Digital do zero ao avançado', 'Você irá aprender tudo sobre Fotografia Digital do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Edição de Vídeo com Premiere', 'Você irá aprender tudo sobre edição de vídeo com Adobe Premiere do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'After Effects do zero ao avançado', 'Você irá aprender tudo sobre After Effects do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Criação de Apps com Adalo', 'Você irá aprender tudo sobre criação de apps com Adalo do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Figma do zero ao avançado', 'Você irá aprender tudo sobre design e prototipagem no Figma do zero até se tornar um profissional', current_timestamp());

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `criado_em`) VALUES (NULL, 'Gestão de Projetos com Scrum', 'Você irá aprender tudo sobre Scrum e gestão ágil de projetos do zero até se tornar um profissional', current_timestamp());
