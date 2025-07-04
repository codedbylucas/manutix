<?php
use core\Router;

$router = new Router();

// LOGIN
$router->get('/login', 'LoginController@index');
$router->post('/login', 'LoginController@autenticar');
$router->get('/logout', 'LoginController@logout');

// DASHBOARD
$router->get('/dashboard', 'DashboardController@index');

// CHAMADOS
$router->get('/chamados/novo', 'chamados\ChamadosController@index');
$router->post('/chamados/novo', 'chamados\ChamadosController@salvar');   
$router->get('/chamados', 'chamados\ChamadosController@listar');      

// TECNICO
$router->get('/tecnico/chamados', 'tecnico\TecnicoController@index'); 

// GESTAO ADMIN
$router->get('/admin/usuarios/novo', 'admin\GestaoAdminController@index'); 
$router->post('/admin/usuarios/novo', 'admin\GestaoAdminController@salvar'); 
$router->get('/admin/usuarios', 'admin\GestaoAdminController@listar'); 

// SETORES
$router->get('/admin/setores', 'admin\GestaoAdminController@setores');
$router->post('/admin/setores/novo', 'admin\GestaoSetoresController@salvar');
$router->get('/admin/setores/listar', 'admin\GestaoSetoresController@listar'); 
$router->post('/admin/setores/editar', 'admin\GestaoSetoresController@editar');