<?php
namespace SlimBooBoo;

use BooBoo\BooBoo;

class Middleware {

	public function __construct(array $defaultPaths = null) {
		if( ! is_null($defaultPaths)) {
			foreach($defaultPaths as $format => $path) {
				BooBoo::defaultErrorPath($format, $path);
			}
		}
	}

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next) {
		$app = $next;
    $container = $app->getContainer();

		BooBoo::setUp();

		$container['errorHandler'] = function($c) {
			return function($request, $response, $exception) {

				ob_start();
				BooBoo\BooBoo::exceptionHandler($exception);
				$buffer = ob_get_contents();
				ob_end_clean();

				$response = new \HTTP\Response();
				return $response->overwrite($buffer);
			};
		};

		return $app($request, $response);
	}
}