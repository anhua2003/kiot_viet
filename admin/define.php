<?php
include_once 'library/smarty/Smarty.class.php';
include_once 'include/db.php';
include_once 'include/session.php';
include_once 'include/global.php';
include_once 'include/model.php';


$st = new Smarty();

$models = __DIR__.'/class';
$routeFiles = scandir($models);

foreach ($routeFiles as $routeFile) {
    $routeFilePath = $models . '/' . $routeFile;
    if (is_file($routeFilePath) && preg_match('/^.*\.(php)$/i', $routeFilePath))
    require_once $routeFilePath;
}

include_once '#directthumuc/config.php';
include_once 'include/tiktok.php';
