<?php
if (empty(session_id())) {
    session_start();
}
$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'];
define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR);
define('BASE_PATH', 'base' . DIRECTORY_SEPARATOR);
define('PUBLIC_PATH', 'public' . DIRECTORY_SEPARATOR);
define('BASE_URL', 'http://localhost:8080/');
require_once $_SERVER['DOCUMENT_ROOT'] . "ChromePhp.php";
require_once ROOT_PATH . 'config.php';
date_default_timezone_set($systemConfig["system"]["timezone"]);


require_once $_SERVER['DOCUMENT_ROOT'] . BASE_PATH . 'functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . BASE_PATH . 'database-provider.php';
require_once $_SERVER['DOCUMENT_ROOT'] . BASE_PATH . 'base.php';
require_once $_SERVER['DOCUMENT_ROOT'] . BASE_PATH . 'engine.php';

$engine = new Engine();