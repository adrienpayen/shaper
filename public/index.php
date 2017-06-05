<?php

//session_start();
require "../conf.inc.php";

require_once '../vendor/autoload.php';

require_once '../Core/Autoloader.php';
$loader = new Autoloader();
$loader->register();

$loader->addNamespace('Core', '../Core');
$loader->addNamespace('Entities', '../src/entities');

\Core\Basics\Routing::load();


