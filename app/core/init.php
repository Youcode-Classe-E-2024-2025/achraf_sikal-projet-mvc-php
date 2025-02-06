<?php

spl_autoload_register(function($class_name)
{
    $model = __DIR__."/../models/".$class_name.".php";
    require $model;
});
require "session.php";

require_once __DIR__.'/../../vendor/autoload.php';
require __DIR__."/../config/config.php";
require "functions.php";
require "database.php";
require "model.php";
require "Controller.php";
require "app.php";