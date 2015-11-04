<?php
namespace SlimBooboo;

use Exception\BooBoo;

class Middleware {

	protected $app;

	public function __construct($app, \Psr\Log\LoggerInterface $logger = null, $lastAction = null, $ignore = [], array $defaultPaths = null) {
		$this->app = $app;

		// Start BooBoo
		BooBoo::setUp($logger, $lastAction, $ignore);

		if( ! is_null($defaultPaths)) {
			foreach($defaultPaths as $format => $path) {
				BooBoo::defaultErrorPath($format, $path);
			}
		}
	}

	public function __invoke(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, $next) {
		$container = $this->app->getContainer();

		// Overwrite the errorHandler
		$container['errorHandler'] = function($c) {
			return function($request, $response, $exception) {

				// Store the BooBoo error body response in a buffer
				ob_start();
				BooBoo::exceptionHandler($exception);
				$buffer = ob_get_contents();
				ob_end_clean();

				// By creating a new response object, all the headers set by BooBoo get resynced
				$response = new \HTTP\Response();

				return $response->overwrite($buffer);
			};
		};

		return $next($request, $response);
	}
}