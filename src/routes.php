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
$router->get('/chamados/novo', 'ChamadosController@index');
$router->post('/chamados/novo', 'ChamadosController@salvar');   
$router->get('/chamados', 'ChamadosController@listar');      

// TECNICO
$router->get('/tecnico/chamados', 'TecnicoController@index'); 

// GESTAO ADMIN
$router->get('/admin/usuarios/novo', 'GestaoAdminController@index'); 
$router->post('/admin/usuarios/novo', 'GestaoAdminController@salvar'); 
$router->get('/admin/usuarios', 'GestaoAdminController@listar');     
$router->get('/admin/setores', 'GestaoAdminController@setores'); 
