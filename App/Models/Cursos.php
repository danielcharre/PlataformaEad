<?php 

    namespace App\Models;
    use MF\Model\Model;


    Class Cursos extends Model{


        private $id;
        private $titulo;
        private $descricao;


        public function __get($attr) {
            return $this->$attr;
        }

        public function __set($attr, $value) {
            $this->$attr = $value;
        }


        public function listarTodos() {
            $query = "SELECT * FROM cursos ORDER BY criado_em DESC";
            return $this->db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
        }


        public function matricular($id_aluno, $id_curso) {

            // Verifica se já está matriculado
            $query = "SELECT * FROM aluno_curso WHERE id_aluno = :id_aluno AND id_curso :id_curso";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":id_aluno", $id_aluno);
            $stmt->bindValue(":id_curso", $id_curso);
            $stmt->execute();

            if($stmt->rowCount() == 0) {
                $query = "INSERT INTO aluno_curso (id_aluno, id_curso) VALUES (:id_aluno, :id_curso)";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(":id_aluno", $id_aluno);
                $stmt->bindValue(":id_curso", $id_curso);
                $stmt->execute();
            }
        }

        public function listarCursosMatriculados($id_aluno) {

            $query = "
                        SELECT c.id, c.titulo, c.descricao, c.criado_em
                        FROM cursos c
                        JOIN aluno_curso ac ON c.id = ac.id_curso
                        WHERE ac.id_aluno = :id_aluno
                        ORDER BY c.criado_em DESC
                    ";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":id_aluno", $id_aluno);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }


        public function salvar() {
            $query = "INSERT INTO cursos (titulo, descricao) VALUES (:titulo, :descricao)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':titulo', $this->__get('titulo'));
            $stmt->bindValue(':descricao', $this->__get('descricao'));
            $stmt->execute();
        }
        

        public function getCursoPorId($id) {
            $query = "SELECT * FROM cursos WHERE id = :id LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        
        public function atualizar() {
            $query = "UPDATE cursos SET titulo = :titulo, descricao = :descricao WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':titulo', $this->__get('titulo'));
            $stmt->bindValue(':descricao', $this->__get('descricao'));
            $stmt->execute();
        }
        
        public function excluir() {
            // Excluir aulas vinculadas ao curso
            $queryAulas = "DELETE FROM aulas WHERE id_curso = :id";
            $stmtAulas = $this->db->prepare($queryAulas);
            $stmtAulas->bindValue(':id', $this->__get('id'));
            $stmtAulas->execute();
        
            // Excluir o curso
            $queryCurso = "DELETE FROM cursos WHERE id = :id";
            $stmtCurso = $this->db->prepare($queryCurso);
            $stmtCurso->bindValue(':id', $this->__get('id'));
            $stmtCurso->execute();
        }
        
        
    }