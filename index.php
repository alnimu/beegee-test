<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once(dirname(__FILE__).'/core/Base.php');

$loader = require(__DIR__ . '/application/vendor/autoload.php');

$config = require(dirname(__FILE__).'/application/config/main.php');
$app = new Application($config);
$app->run();

