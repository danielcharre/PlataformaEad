<?php 

    namespace App\Models;
    use MF\Model\Model;


    Class Aula extends Model{

        private $id;
        private $id_curso;
        private $titulo;
        private $descricao;
        private $video_url;
        private $ordem;

        public function __get($attr) {
            return $this->$attr;
        }

        public function __set($attr, $value) {
            $this->$attr = $value;
        }

        public function listarPorCurso($id_curso) {
            $query = "SELECT * FROM aulas WHERE id_curso = :id_curso ORDER BY ordem ASC";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_curso', $id_curso);
            $stmt->execute();
    
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }


        public function marcarComoVista($id_aluno, $id_aula) {

            $query = "INSERT IGNORE INTO aulas_vistas (id_aluno, id_aula) VALUES (:id_aluno, :id_aula)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":id_aluno", $id_aluno);
            $stmt->bindValue(":id_aula", $id_aula);
            $stmt->execute();
        }


        public function listarAulasVistas($id_aluno, $id_curso) {
            $query = "
                SELECT pa.id_aula
                FROM progresso_aula pa
                JOIN aulas a ON pa.id_aula = a.id
                WHERE pa.id_aluno = :id_aluno
                  AND a.id_curso = :id_curso
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_aluno', $id_aluno);
            $stmt->bindValue(':id_curso', $id_curso);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_COLUMN); // retorna array de IDs
        }
        


        public function marcarComoAssistida($id_aluno, $id_aula) {
            $query = "INSERT IGNORE INTO progresso_aula (id_aluno, id_aula) VALUES (:id_aluno, :id_aula)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_aluno', $id_aluno);
            $stmt->bindValue(':id_aula', $id_aula);
            $stmt->execute();
        }
        
        public function calcularProgresso($id_curso, $id_aluno) {
            $query_total = "SELECT COUNT(*) as total FROM aulas WHERE id_curso = :id_curso";
            $stmt = $this->db->prepare($query_total);
            $stmt->bindValue(':id_curso', $id_curso);
            $stmt->execute();
            $total = $stmt->fetch(\PDO::FETCH_ASSOC)['total'];
        
            $query_feitas = "SELECT COUNT(*) as feitas 
                             FROM progresso_aula pa 
                             JOIN aulas a ON pa.id_aula = a.id 
                             WHERE a.id_curso = :id_curso AND pa.id_aluno = :id_aluno";
            $stmt = $this->db->prepare($query_feitas);
            $stmt->bindValue(':id_curso', $id_curso);
            $stmt->bindValue(':id_aluno', $id_aluno);
            $stmt->execute();
            $feitas = $stmt->fetch(\PDO::FETCH_ASSOC)['feitas'];
        
            if ($total == 0) return 0;
            return round(($feitas / $total) * 100);
        }

        public function getAulaPorId($id_aula) {
            $query = "SELECT * FROM aulas WHERE id = :id_aula";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_aula', $id_aula);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function salvar() {
            $query = "INSERT INTO aulas (id_curso, titulo, descricao, video_url, ordem) 
                      VALUES (:id_curso, :titulo, :descricao, :video_url, :ordem)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_curso', $this->__get('id_curso'));
            $stmt->bindValue(':titulo', $this->__get('titulo'));
            $stmt->bindValue(':descricao', $this->__get('descricao'));
            $stmt->bindValue(':video_url', $this->__get('video_url'));
            $stmt->bindValue(':ordem', $this->__get('ordem'));
            $stmt->execute();
        }

        
        
        public function atualizar() {
            $query = "UPDATE aulas SET titulo = :titulo, descricao = :descricao, video_url = :video_url, ordem = :ordem WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':titulo', $this->__get('titulo'));
            $stmt->bindValue(':descricao', $this->__get('descricao'));
            $stmt->bindValue(':video_url', $this->__get('video_url'));
            $stmt->bindValue(':ordem', $this->__get('ordem'));
            $stmt->execute();
        }
        
        
        public function excluir() {
            $query = "DELETE FROM aulas WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
        }

        public static function converterParaEmbed($url) {
            if (strpos($url, 'watch?v=') !== false) {
                return str_replace('watch?v=', 'embed/', $url);
            } elseif (strpos($url, 'youtu.be/') !== false) {
                $id = substr(parse_url($url, PHP_URL_PATH), 1);
                return 'https://www.youtube.com/embed/' . $id;
            }
            return $url; // caso já esteja no formato embed
        }
        
        
        
    }