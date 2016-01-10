<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(E_ALL ^ E_NOTICE);

use Framework\App;

include '../../Framework/App.php';
include '../Routers/DummyRouter.php';

$app = App::getInstance();

$app->run();