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
// $router->get('/chamados/novo', 'chamados\ChamadosController@index');
$router->post('/chamados/novo', 'chamados\ChamadosController@salvar');
$router->get('/chamados', 'chamados\ChamadosController@listar');
$router->get('/chamados/novo', 'chamados\ChamadosController@novo');
$router->post('/chamados/excluir', 'chamados\ChamadosController@excluir');
$router->post('/chamados/editar', 'chamados\ChamadosController@editar');

// TECNICO
$router->get('/tecnico/chamados', 'tecnico\TecnicoController@listar');
$router->get('/tecnico/todosChamados', 'tecnico\TodosChamadosController@listar');
$router->post('/chamados/assumir', 'tecnico\TodosChamadosController@assumir');

// GESTAO ADMIN
$router->get('/admin/usuarios/novo', 'admin\GestaoAdminController@index');
$router->post('/admin/usuarios/novo', 'admin\GestaoAdminController@salvar');
$router->get('/admin/usuarios', 'admin\GestaoAdminController@listar');
$router->get('/admin/usuarios/excluir/{id}', 'admin\GestaoAdminController@excluir');
$router->get('/admin/usuarios/editar/{id}', 'admin\GestaoAdminController@editar');

// SETORES
$router->get('/admin/setores', 'admin\GestaoSetoresController@setores');
$router->post('/admin/setores/novo', 'admin\GestaoSetoresController@salvar');
$router->get('/admin/setores/listar', 'admin\GestaoSetoresController@listar');
$router->post('/admin/setores/editar', 'admin\GestaoSetoresController@editar');
$router->post('/admin/setores/excluir', 'admin\GestaoSetoresController@excluir');

// AVALIAÇÃO
$router->get('/avaliacoes', 'avaliacao\AvaliacoesController@index');
$router->post('/avaliacoes/salvar', 'avaliacao\AvaliacoesController@salvar');
$router->get('/avaliacoes/listar', 'avaliacao\AvaliacoesController@listar');
