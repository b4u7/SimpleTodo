<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use SimpleTodo\Database;
use Elasticsearch\ClientBuilder;

require __DIR__ . '/vendor/autoload.php';

$config = require 'config.php';
Database::setConfig($config);

$esClient = ClientBuilder::create()->build();
