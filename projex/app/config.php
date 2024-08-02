<?php

define('APP_ROOT', realpath(__DIR__ . '/../'));

$dotenv = Dotenv\Dotenv::createImmutable(APP_ROOT);
$dotenv->load();

define("APP_MODE", $_ENV["APP_MODE"]);
