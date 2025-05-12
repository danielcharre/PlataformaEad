<?php 

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\model\Container;

    class AppController extends Action { 

        public function teste() {

            $cursos = Container::getModel('Cursos');

            
            $this->render('teste');
        }
    }