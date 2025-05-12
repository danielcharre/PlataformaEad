<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\model\Container;

class PainelController extends Action {

    public function dashboard() {
        $this->verificarLogin();

        $id_aluno = $_SESSION['id'];

        $cursoModel = Container::getModel('Cursos');
        $cursos = $cursoModel->listarCursosMatriculados($id_aluno);
        $totalCursos = count($cursos);

        $aulaModel = Container::getModel('Aula');
        $progressoTotal = 0;
        foreach ($cursos as $curso) {
            $progressoTotal += $aulaModel->calcularProgresso($curso['id'], $id_aluno);
        }

        $progressoGeral = $totalCursos > 0 ? round($progressoTotal / $totalCursos) : 0;

        $this->view->nome_aluno = $_SESSION['nome'];
        $this->view->total_cursos = $totalCursos;
        $this->view->progresso_geral = $progressoGeral;

        if ($_SESSION['tipo'] === 'admin') {
            $this->view->cursos_admin = $cursoModel->listarTodos();
        }

        $this->render('dashboard');
    }
}
