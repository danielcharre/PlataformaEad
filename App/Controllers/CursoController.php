<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\model\Container;

use Dompdf\Dompdf;
use Dompdf\Options; 

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
    
        // ✅ Converter todos os links de vídeo para formato embed
        foreach ($this->view->aulas as &$a) {
            $a['video_url'] = \App\Models\Aula::converterParaEmbed($a['video_url']);
        }
    
        $this->view->curso_id = $id_curso;
        $this->view->aulas_vistas = $aula->listarAulasVistas($id_aluno, $id_curso);
        $this->view->progresso = $aula->calcularProgresso($id_curso, $id_aluno);
    
        $this->render('aulas');
    }



    public function assistirAula() {
        $this->verificarLogin();
    
        $id_aluno = $_SESSION['id'];
        $id_aula = $_POST['id'];
        $id_curso = $_POST['curso'];
    
        $curso = Container::getModel('Cursos');
        $matriculado = $curso->listarCursosMatriculados($id_aluno);
        $ids_matriculados = array_column($matriculado, 'id');
    
        if (!in_array($id_curso, $ids_matriculados)) {
            header('Location: /painel/meuscursos');
            exit;
        }
    
        $progresso = Container::getModel('Progresso');
        $progresso->registrar($id_aluno, $id_aula);
    
        header("Location: /painel/curso?id=$id_curso");
        exit;
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

    // Converte link para formato embed
        $video_url = \App\Models\Aula::converterParaEmbed($_POST['video_url']);

        $aula->__set('id_curso', $_POST['id_curso']);
        $aula->__set('titulo', $_POST['titulo']);
        $aula->__set('descricao', $_POST['descricao']);
        $aula->__set('video_url', $video_url);
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

        // Converte link para formato embed
        $video_url = \App\Models\Aula::converterParaEmbed($_POST['video_url']);

        $aula->__set('id', $_POST['id']);
        $aula->__set('titulo', $_POST['titulo']);
        $aula->__set('descricao', $_POST['descricao']);
        $aula->__set('video_url', $video_url);
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
    

    public function excluirCurso() {
        $this->verificarAdmin();
    
        $curso = Container::getModel('Cursos');
        $curso->__set('id', $_GET['id']);
        $curso->excluir();
    
        header('Location: /painel/cursos');
    }
    
 

    public function gerarCertificado() {
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
        $progresso = $aula->calcularProgresso($id_curso, $id_aluno);

        if ($progresso < 100) {
            echo "Certificado disponível apenas com 100% de conclusão.";
            exit;
        }

        // Dados do certificado
        $nome = $_SESSION['nome'];
        $curso_info = $curso->getCursoPorId($id_curso);
        $titulo_curso = $curso_info['titulo'];
        $data = date('d/m/Y');

        // HTML do certificado
        $html = "
                <style>
                    body {
                        font-family: Georgia, serif;
                        padding: 40px;
                        background: #fff;
                    }
                    .certificado {
                        border: 10px solid #4a90e2;
                        padding: 50px;
                        text-align: center;
                        box-shadow: 0 0 30px rgba(0,0,0,0.1);
                    }
                    .titulo {
                        font-size: 32px;
                        font-weight: bold;
                        color: #333;
                        margin-bottom: 20px;
                    }
                    .texto {
                        font-size: 18px;
                        margin: 20px 0;
                    }
                    .curso {
                        font-size: 24px;
                        font-weight: bold;
                        color: #4a90e2;
                        margin: 30px 0;
                    }
                    .assinatura {
                        margin-top: 60px;
                        text-align: center;
                    }
                    .linha {
                        width: 200px;
                        border-top: 1px solid #000;
                        margin: 0 auto 5px;
                    }
                    .data {
                        margin-top: 40px;
                        font-size: 16px;
                    }
                </style>

                <div class='certificado'>
                    <div class='titulo'>Certificado de Conclusão</div>
                    <div class='texto'>Certificamos que</div>
                    <div class='curso'>$nome</div>
                    <div class='texto'>concluiu com êxito o curso</div>
                    <div class='curso'>$titulo_curso</div>
                    <div class='texto'>com 100% de aproveitamento.</div>
                    <div class='data'>Emitido em: $data</div>

                    <div class='assinatura'>
                        <div class='linha'></div>
                        <div>Coordenação Acadêmica</div>
                    </div>
                </div>
                ";


        // Gerar PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("certificado-$titulo_curso.pdf", ["Attachment" => false]);
    }

}
