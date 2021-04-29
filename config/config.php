<?php


define('ROOT', dirname(__DIR__) . '/');
define('CONTROLLER_PATH', ROOT . "Controllers/");
define('MODEL_PATH', ROOT . "Models/");
define('VIEW_PATH', ROOT . "Views/");
define('ASSSETS_PATH', ROOT . 'assets/');

require_once('db.php');
require_once('route.php');

require_once(CONTROLLER_PATH . 'Controller.php');
require_once(MODEL_PATH . 'Model.php');
require_once(VIEW_PATH . 'View.php');

Router::buildRoute();
