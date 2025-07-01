<?php

namespace src\controllers;

use src\models\Usuario;
use \core\Controller;

class DashBoardController extends Controller
{

    public function index()
    {
        if (!isset($_SESSION['usuario_id'])) {
            $this->redirect('/login');
            exit;
        }

        $this->render('dashboard');
    }
}
