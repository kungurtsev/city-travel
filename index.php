<?php

use App\App\Router;
use App\App\Controller;
use App\App\Application;

error_reporting(E_ALL);
ini_set('display_errors',true);

require_once 'bootstrap.php';

$router = new Router();

$router->get('/',      Controller::class . '@index');
$router->get('/about', Controller::class . '@about');

$router->get('/info', function() {
	return new \App\View\View('info', ['title' => 'Info page']);
});

$application = new Application($router);

$application->run();
