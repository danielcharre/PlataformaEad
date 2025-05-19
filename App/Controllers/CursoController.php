<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\model\Container;

class CursoController extends Action {

    public function index() {
        $this->verificarLogin();

        $curso = Container::getModel('Cursos');
        $this->view->cursos = $curso->listarTodos();

        $this->render('cursos');
    }

    public function matricular() {
        $this->verificarLogin();

        $id_curso = $_GET['id'];
        $id_aluno = $_SESSION['id'];

        $curso = Container::getModel('Cursos');
        $curso->matricular($id_aluno, $id_curso);

        header("Location: /painel/cursos");
        exit;
    }

    public function meusCursos() {
        $this->verificarLogin();

        $curso = Container::getModel('Cursos');
        $this->view->meus_cursos = $curso->listarCursosMatriculados($_SESSION['id']);

        $this->render('meus_cursos');
    }

    public function verCurso() {
        $this->verificarLogin();

        $id_curso = $_GET['id'];
        $id_aluno = $_SESSION['id'];

        $curso = Container::getModel('Cursos');
        $matriculado = $curso->listarCursosMatriculados($id_aluno);
        $matriculado_ids = array_column($matriculado, 'id');

        if (!in_array($id_curso, $matriculado_ids)) {
            header('Location: /painel/meuscursos');
            exit;
        }

        $aula = Container::getModel('Aula');
        $this->view->aulas = $aula->listarPorCurso($id_curso);
        $this->view->curso_id = $id_curso;
        $this->view->aulas_vistas = $aula->listarAulasVistas($id_aluno, $id_curso);
        $this->view->progresso = $aula->calcularProgresso($id_curso, $id_aluno);

        $this->render('aulas');
    }


    public function assistir() {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location: /');
            exit;
        }
    
        $id_aluno = $_SESSION['id'];
        $id_aula = $_GET['id'];
        $id_curso = $_GET['curso'];
    
        $aula = Container::getModel('Aula');
        $aula->marcarComoAssistida($id_aluno, $id_aula);
    
        header("Location: /painel/curso?id=" . $id_curso);
        exit;
    }

    public function assistirAula() {
        $this->verificarLogin();

        $id_aluno = $_SESSION['id'];
        $id_aula = $_GET['id'];
        $id_curso = $_GET['curso'];

        $curso = Container::getModel('Cursos');
        $matriculado = $curso->listarCursosMatriculados($id_aluno);
        $ids_matriculados = array_column($matriculado, 'id');

        if (!in_array($id_curso, $ids_matriculados)) {
            header('Location: /painel/meuscursos');
            exit;
        }

        $progresso = Container::getModel('Progresso');
        $progresso->registrar($id_aluno, $id_aula);

        $aula = Container::getModel('Aula');
        $this->view->aula = $aula->getAulaPorId($id_aula);

        $this->render('assistir_aula');
    }

    public function formNovoCurso() {
        $this->verificarAdmin();
        $this->render('novo_curso');
    }

    public function salvarCurso() {
        $this->verificarAdmin();

        $curso = Container::getModel('Cursos');
        $curso->__set('titulo', $_POST['titulo']);
        $curso->__set('descricao', $_POST['descricao']);
        $curso->salvar();

        header('Location: /painel/cursos');
    }

    public function listarAulasAdmin() {
        $this->verificarAdmin();
    
        $id_curso = $_GET['id'];
        $aula = Container::getModel('Aula');
        $this->view->aulas = $aula->listarPorCurso($id_curso);
        $this->view->curso_id = $id_curso;
    
        $this->render('aulas_admin');
    }
    
    public function formNovaAula() {
        $this->verificarAdmin();
        $this->view->curso_id = $_GET['id'];
        $this->render('nova_aula');
    }
    
    public function salvarAula() {
        $this->verificarAdmin();
    
        $aula = Container::getModel('Aula');
        $aula->__set('id_curso', $_POST['id_curso']);
        $aula->__set('titulo', $_POST['titulo']);
        $aula->__set('descricao', $_POST['descricao']);
        $aula->__set('video_url', $_POST['video_url']);
        $aula->__set('ordem', $_POST['ordem']);
        $aula->salvar();
    
        header("Location: /admin/curso/aulas?id=" . $_POST['id_curso']);
    }
    

    public function editarAula() {
        $this->verificarAdmin();
    
        $aula = Container::getModel('Aula');
        $this->view->aula = $aula->getAulaPorId($_GET['id']);
        $this->view->curso_id = $_GET['curso'];
    
        $this->render('editar_aula');
    }
    
    public function atualizarAula() {
        $this->verificarAdmin();
    
        $aula = Container::getModel('Aula');
        $aula->__set('id', $_POST['id']);
        $aula->__set('titulo', $_POST['titulo']);
        $aula->__set('descricao', $_POST['descricao']);
        $aula->__set('video_url', $_POST['video_url']);
        $aula->__set('ordem', $_POST['ordem']);
        $aula->atualizar();
    
        header("Location: /admin/curso/aulas?id=" . $_POST['id_curso']);
    }
    
    public function excluirAula() {
        $this->verificarAdmin();
    
        $aula = Container::getModel('Aula');
        $aula->__set('id', $_GET['id']);
        $aula->excluir();
    
        header("Location: /admin/curso/aulas?id=" . $_GET['curso']);
    }

    public function editarCurso() {
        $this->verificarAdmin();
    
        $curso = Container::getModel('Cursos');
        $this->view->curso = $curso->getCursoPorId($_GET['id']);
    
        $this->render('editar_curso');
    }
    
    public function atualizarCurso() {
        $this->verificarAdmin();
    
        $curso = Container::getModel('Cursos');
        $curso->__set('id', $_POST['id']);
        $curso->__set('titulo', $_POST['titulo']);
        $curso->__set('descricao', $_POST['descricao']);
        $curso->atualizar();
    
        header('Location: /painel/cursos');
    }
    
    
}
