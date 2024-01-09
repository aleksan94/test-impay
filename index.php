<?php

use Aleks\TestImpay\Routes;

require_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

$flights = json_decode(file_get_contents(__DIR__.'/flights.json'), 1);

$routes = new Routes($flights);
$longestRoute = $routes->getLongestRoute();

$output = 
<<<EOF
Самый длинный маршрут:
с {$longestRoute->timeFrom()} по {$longestRoute->timeTo()}
продолжительность: {$longestRoute->durationFormat()}
EOF;

echo "<pre>";print_r($output);echo "</pre>";