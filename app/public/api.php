<?php

require_once "../bootstrap.php";

$app = new \Slim\App();
$container = $app->getContainer();
$container['ApiController'] = new \Appthis\Controller\ApiController();


/***** API methods *****/

$app->get('/api/stats', 'ApiController:getStatsByDates');
$app->get('/api/stats/publishers', 'ApiController:getStatsByPublishers');
$app->get('/api/stats/platforms', 'ApiController:getStatsByPlatform');
$app->get('/api/publishers', 'ApiController:getPublishers');
$app->get('/api/countries', 'ApiController:getCountries');
$app->get('/api/platforms', 'ApiController:getPlatforms');


// Run application
$app->run();




