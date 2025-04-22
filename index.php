<?php

use Symfony\Component\Dotenv\Dotenv;

define('BASE_PATH', __DIR__);

require_once BASE_PATH . '/vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(BASE_PATH . '/.env');
