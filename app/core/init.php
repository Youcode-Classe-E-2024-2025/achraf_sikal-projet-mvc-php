<?php
spl_autoload_register(function($class_name)
{
    require __DIR__."/../Model/".$class_name."Model.php";
});



require __DIR__."/../config/config.php";
require "functions.php";
require "database.php";
require "model.php";
require "Controller.php";
require "app.php";