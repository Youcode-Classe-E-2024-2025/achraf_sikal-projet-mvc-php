<?php

require_once 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Specify the directory where your templates are stored
$loader = new FilesystemLoader('templates');

// Initialize Twig
$twig = new Environment($loader);

// Render a template
echo $twig->render('index.html.twig', ['name' => 'John Doe']);
