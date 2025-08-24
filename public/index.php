<?php
declare(strict_types=1);

use App\Core\Router;

require __DIR__ . '/../vendor/autoload.php';
session_start();

$router = new Router(require __DIR__ . '/../config/config.php');

// Guest routes
$router->get('/', 'AuthController@login');
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@doLogin');
$router->get('/register', 'AuthController@register');
$router->post('/register', 'AuthController@doRegister');
$router->get('/logout', 'AuthController@logout');

// Authenticated routes
$router->get('/contacts', 'ContactController@index', true);
$router->get('/contacts/view', 'ContactController@show', true);
$router->post('/contacts/create', 'ContactController@create', true);
$router->post('/contacts/update', 'ContactController@update', true);
$router->post('/contacts/delete', 'ContactController@delete', true);

$router->dispatch();
