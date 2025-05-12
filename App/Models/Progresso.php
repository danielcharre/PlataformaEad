<?php 
    namespace App\Models;
    use MF\Model\Model;
    
    class Progresso extends Model {
    
        public function registrarAssistencia($id_aluno, $id_aula) {
            $query = "SELECT * FROM progresso_aula WHERE id_aluno = :id_aluno AND id_aula = :id_aula";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_aluno', $id_aluno);
            $stmt->bindValue(':id_aula', $id_aula);
            $stmt->execute();
    
            if ($stmt->rowCount() == 0) {
                $insert = "INSERT INTO progresso_aula (id_aluno, id_aula) VALUES (:id_aluno, :id_aula)";
                $stmt = $this->db->prepare($insert);
                $stmt->bindValue(':id_aluno', $id_aluno);
                $stmt->bindValue(':id_aula', $id_aula);
                $stmt->execute();
            }
        }

        public function registrar($id_aluno, $id_aula) {
            $query = "INSERT IGNORE INTO progresso_aula (id_aluno, id_aula) VALUES (:id_aluno, :id_aula)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_aluno', $id_aluno);
            $stmt->bindValue(':id_aula', $id_aula);
            $stmt->execute();
        }
        
    }
?>    