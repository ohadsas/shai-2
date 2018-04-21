<?php

require_once __DIR__ . "/../bootstrap.php";

$app = new \Slim\App();
$config = [
	'settings' => [
		'displayErrorDetails' => true,
		'twig' => \Appthis\Helper\Config::getViewEngine(),
	]
];
$app = new \Slim\App($config);


$app->get('/', function ($request, $response, $args) {
	return $this->get('settings')['twig']->render('publisher_view.html', [
		'menuItem' => 'publishers'
	]);
});

$app->get('/publishers', function ($request, $response, $args) {
	return $this->get('settings')['twig']->render('publisher_view.html', [
		'menuItem' => 'publishers'
	]);
});

$app->get('/dates', function ($request, $response, $args) {
	return $this->get('settings')['twig']->render('date_view.html', [
		'menuItem' => 'dates'
	]);
});

$app->get('/platforms', function ($request, $response, $args) {
	return $this->get('settings')['twig']->render('platform_view.html', [
		'menuItem' => 'platforms'
	]);
});

$app->run();
