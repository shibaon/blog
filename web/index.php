<?php
chdir(__DIR__ . '/..');
$loader = require_once __DIR__ . '/../vendor/autoload.php';

$app = new Svi\Application();
$app->run();