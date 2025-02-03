<?php
require_once __DIR__.'/../../../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class home extends controller{
    public function index(){
        echo 'aff';
        $data['title'] = 'home';
        $this->view('home',$data);
        $loader = new FilesystemLoader('templates');
        $twig = new Environment($loader);

        echo $twig->render('nav.html.twig', ['name' => 'John Doe','ROOT'=>ROOT, 'style'=>'http://localhost/sikal_achraf-youdemy/public']);
    }
}