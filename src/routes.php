<?php
use core\Router;

$router = new Router();

//TELA LOGIN
$router->get('/login', 'LoginController@index');
$router->post('/login', 'LoginController@autenticar');
$router->get('/logout', 'LoginController@logout');

//DASHBOARD
$router->get('/dashboard', 'DashboardController@index');

//SOLICITACAO
$router->get('/cadastro', 'SolicitacaoController@index');
$router->get('/listar', 'SolicitacaoController@listar');


//SETORES
$router->get('/setores', 'GestaoSetoresController@index');