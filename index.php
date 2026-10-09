<?php
session_start();

require $_SERVER['DOCUMENT_ROOT'] . '/Tourism/assets/app-data/dependencies.php';

use Routers\Router;
use Controllers\Controller;
use Controllers\Errors as ErrorsController;
use Controllers\Home;
use Controllers\Auth;
use Controllers\Attractions;
use Controllers\Bookings;
use Rendering\View;

$router = new Router();

$router->get('/', Home::class . '::index');
$router->get('/about', Controller::class . '::about');

$router->get('/attraction', Attractions::class . '::attraction');
$router->get('/attractions', Attractions::class . '::index');

$router->get('/guides', Controller::class . '::guides');

$router->post('/booking', Bookings::class . '::perform_deal');
$router->get('/bookings', Bookings::class . '::index');

$router->get('/auth/signin', Auth::class . '::signin_index');
$router->post('/auth/signin', Auth::class . '::signin');
$router->post('/auth/signin/component', Auth::class . '::signin_component');

$router->get('/auth/signout', Auth::class . '::signout');

$router->get('/auth/signup', Auth::class . '::signup_index');
$router->post('/auth/signup', Auth::class . '::signup');
$router->post('/auth/signup/component', Auth::class . '::signup_component');

$router->set_not_found_action(ErrorsController::class . '::index');
$router->run();