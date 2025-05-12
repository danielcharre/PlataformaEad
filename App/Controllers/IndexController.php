<?php 

    namespace App\Controllers;
    
    # Recursos do Miniframework 
    use MF\Controller\Action;
    use MF\model\Container;
    
    class IndexController extends Action {

        

        public function index() {            
            $this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
            $this->render('index');
        }

        public function inscreverse() {

            $this->view->aluno = [
                'nome'  => '',
                'email' => '',
                'senha' => ''
            ];

            $this->view->erroCadastro = false;
            $this->render('inscreverse');
        }

        public function registrar() {

            $aluno = Container::getModel('Alunos');
            $aluno->__set('nome', $_POST['nome']);
            $aluno->__set('email', $_POST['email']);
            $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            $aluno->__set('senha', $senha_hash);


            if($aluno->validarCadastro() && count($aluno->getUserEmail()) == 0) {

                $aluno->salvar();
                $this->render('cadastro');

            } else {

                $this->view->aluno = [
                    'nome'  => $_POST['nome'],
                    'email' => $_POST['email'],
                    'senha' => $_POST['senha']
                ];

                $this->view->erroCadastro = true;
                $this->render('inscreverse');
            }

        }
        

        
    }

?>