<?php

require '../vendor/autoload.php';

use Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware;

$app = new \Slim\App([
    'debug'         => true,
    'whoops.editor' => 'sublime'
]);

$logger = (new \Monolog\Logger('TEST'))
  ->pushHandler(
    new \Monolog\Handler\FingersCrossedHandler(
      new \Monolog\Handler\StreamHandler(__DIR__.'/log'),
      \Monolog\Logger::WARNING
    )
  );

$app->add(new \SlimBooboo\Middleware(
  $app,
  $logger,
  function() { error_log("testing callable");},
  [E_NOTICE, E_DEPRECATED]
));

$logger->notice('Starting the routing');

$app->get('/exception/', function($req, $res, $arg) {
	throw new Exception("Error Processing Request", 1);
});

$app->get('/exception-booboo/', function($req, $res, $arg) {
  throw new \Exception\BooBoo(
  new MyBooBoos\DatabaseError('The message for the client', 'The message for the logs', [1,2,3,4]),
  (new \HTTP\Response())->withStatus(404)->withLanguage(\HTTP\Response\Language::DUTCH));
});

$app->get('/error/', function($req, $res, $arg) {
	$a->B();
});

$app->run();