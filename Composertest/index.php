<?php
require __DIR__."/vendor/autoload.php";

$obj = new \App\Http\Controller\HomeController();

$re = new \ReflectionClass($obj);

var_dump($re->getDocComment());

?>