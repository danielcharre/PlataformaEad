<?php 

    namespace App\Models;
    use MF\Model\Model;


    Class Alunos extends Model{

        private $id;
        private $nome;
        private $email;
        private $senha;


        public function __get($attr) {
            return $this->$attr;
        }

        public function __set($attr, $value) {
            $this->$attr = $value;
        }


        public function salvar() {

            $query = "INSERT INTO alunos (nome, email, senha) VALUES (:nome, :email, :senha)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":nome", $this->__get('nome'));
            $stmt->bindValue(":email", $this->__get('email'));
            $stmt->bindValue(":senha", $this->__get('senha'));
            $stmt->execute();

            return $this;
        }


        public function validarCadastro() {
            $valido = true;

            if(empty($this->__get('nome')) || strlen($this->__get('nome')) < 3) {
                $valido = false;
            }
            if(empty($this->__get('email')) || strlen($this->__get('email')) < 3) {
                $valido = false;
            }
            if(empty($this->__get('senha')) || strlen($this->__get('senha')) < 3) {
                $valido = false;
            }
            
            return $valido;
        }
        


        public function getUserEmail() {

            $query = "SELECT nome, email FROM alunos WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":email", $this->__get('email'));
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        }


        public function autenticar() {
            $query = "SELECT id, nome, email, senha, tipo FROM alunos WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":email", $this->__get('email'));
            $stmt->execute();
        
            $aluno = $stmt->fetch(\PDO::FETCH_ASSOC);
        
            if ($aluno && password_verify($this->__get('senha'), $aluno['senha'])) {
                $this->__set('id', $aluno['id']);
                $this->__set('nome', $aluno['nome']);
                $this->__set('tipo', $aluno['tipo']); // ✅ isso faltava
            } else {
                return false;
            }
        
            return $this;
        }
        
        
    }

?>