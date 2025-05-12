<?php 

namespace MF\Controller;

abstract class Action {

    protected $view;

    public function __construct() {
        $this->view = new \stdClass();
    }

    protected function render($view, $layout = 'layout') {
        $this->view->page = $view;
        if(file_exists("../App/Views/{$layout}.phtml")){
            require_once "../App/Views/{$layout}.phtml";
        } else {
            $this->content();
        }
    }

    protected function content() {
        # deixando dinamico pegar a view
        $class_atual = get_class($this);
        $class_atual = str_replace('App\\Controllers\\', '', $class_atual);
        $class_atual = strtolower(str_replace('Controller', '', $class_atual));

        require_once "../App/Views/{$class_atual}/{$this->view->page}.phtml";
    }

    # ✅ Novo: verificar se o usuário está logado
    protected function verificarLogin() {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location: /');
            exit;
        }
    }

    # ✅ Novo: verificar se é admin
    protected function verificarAdmin() {
        session_start();
        if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: /painel');
            exit;
        }
    }
}

?>
