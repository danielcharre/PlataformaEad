<?php 

    namespace App;
    use MF\Init\Bootstrap;

    class Route extends Bootstrap{


        protected function initRoutes() {

            $routes['home'] = array(
                'route' => '/',
                'controller' => 'indexController',
                'action' => 'index'
            );

            $routes['inscreverse'] = array(
                'route' => '/inscreverse',
                'controller' => 'indexController',
                'action' => 'inscreverse'
            );

            $routes['registrar'] = array(
                'route' => '/registrar',
                'controller' => 'indexController',
                'action' => 'registrar'
            );

            $routes['autenticar'] = array(
                'route' => '/autenticar',
                'controller' => 'AuthController',
                'action' => 'autenticar'
            );

            $routes['teste'] = array(
                'route' => '/teste',
                'controller' => 'AppController',
                'action' => 'teste'
            );

            $routes['sair'] = array(
                'route' => '/sair',
                'controller' => 'AuthController',
                'action' => 'sair'
            );

            $routes['painel'] = array(
                'route' => '/painel',
                'controller' => 'PainelController',
                'action' => 'dashboard'
            );

            $routes['cursos'] = array(
                'route' => '/painel/cursos',
                'controller' => 'CursoController',
                'action' => 'index'
            );

            $routes['matricular'] = array(
                'route' => '/painel/matricular',
                'controller' => 'CursoController',
                'action' => 'matricular'
            );

            $routes['meus_cursos'] = array(
                'route' => '/painel/meuscursos',
                'controller' => 'CursoController',
                'action' => 'meusCursos'
            );

            $routes['ver_curso'] = [
                'route' => '/painel/curso',
                'controller' => 'CursoController',
                'action' => 'verCurso'
            ];
            

            $routes['marcar_visto'] = [
                'route' => '/painel/marcar_visto',
                'controller' => 'CursoController',
                'action' => 'marcarVisto'
            ];

            $routes['assistir'] = [
                'route' => '/painel/assistir',
                'controller' => 'CursoController',
                'action' => 'assistir'
            ];

            $routes['assistir_aula'] = [
                'route' => '/painel/assistir',
                'controller' => 'CursoController',
                'action' => 'assistirAula'
            ];

            # ROTAS ADMIN

            $routes['admin_novo_curso'] = [
                'route' => '/admin/curso/novo',
                'controller' => 'CursoController',
                'action' => 'formNovoCurso'
            ];
            

            $routes['admin_salvar_curso'] = [
                'route' => '/admin/curso/salvar',
                'controller' => 'CursoController',
                'action' => 'salvarCurso'
            ];


            $routes['admin_listar_aulas'] = [
                'route' => '/admin/curso/aulas',
                'controller' => 'CursoController',
                'action' => 'listarAulasAdmin'
            ];
            
            $routes['admin_nova_aula'] = [
                'route' => '/admin/curso/aula/nova',
                'controller' => 'CursoController',
                'action' => 'formNovaAula'
            ];
            
            $routes['admin_salvar_aula'] = [
                'route' => '/admin/curso/aula/salvar',
                'controller' => 'CursoController',
                'action' => 'salvarAula'
            ];
            
            $routes['admin_editar_aula'] = [
                'route' => '/admin/curso/aula/editar',
                'controller' => 'CursoController',
                'action' => 'editarAula'
            ];
            
            $routes['admin_atualizar_aula'] = [
                'route' => '/admin/curso/aula/atualizar',
                'controller' => 'CursoController',
                'action' => 'atualizarAula'
            ];
            

            $this->setRoutes($routes); 
        }

    }

?>