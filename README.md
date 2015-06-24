# slim-booboo
Booboo's integration for Slim3.0 framework

Install via Composer
---------------------
composer require marcoazn89/slim-booboo:dev-master

Set up
-------
```php
$app->add(new \SlimBooboo\Middleware());
```

Overwrite default templates
----------------------------
```php
// config array overwrites the default error templates. Example:
$configArray= [
	'html'	=>	'some/folder/html.php',
	'json'	=>	'some/folder/json.php',
];

$app->add(new \SlimBooboo\Middleware($configArray));
```

Example
--------
```php
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
```