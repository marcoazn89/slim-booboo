<?php

require '../vendor/autoload.php';

$app = new \Slim\App();

$app->add(new \SlimBooboo\Middleware());

$app->get('/exception/', function($req, $res, $arg) {
	throw new Exception("Error Processing Request", 1);
});

$app->get('/error/', function($req, $res, $arg) {
	$a->B();
});

$app->run();