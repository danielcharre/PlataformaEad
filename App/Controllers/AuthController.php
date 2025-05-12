<?php 

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\model\Container;

    class AuthController extends Action { 

        public function autenticar() {
            $aluno = Container::getModel('Alunos');
        
            $aluno->__set('email', filter_input(INPUT_POST, 'email'));
            $aluno->__set('senha', filter_input(INPUT_POST, 'senha'));
        
            $aluno->autenticar();
        
            if (!empty($aluno->__get('id')) && !empty($aluno->__get('nome'))) {
                session_start();
        
                $_SESSION['id'] = $aluno->__get('id');
                $_SESSION['nome'] = $aluno->__get('nome');
                $_SESSION['tipo'] = $aluno->__get('tipo'); // ✅ Adicionado aqui
        
                header("Location: /painel");
                exit;
        
            } else {
                header("Location: /?login=erro");
                exit;
            }
        }
        

        public function sair() {
            session_start();
            session_destroy();
            session_unset();
            header('Location: /');
            exit;
        }
    }

?>