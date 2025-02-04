<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class user extends controller{
    public function index(){
        $data['title'] = 'home';
        $this->view('user',$data);
        $loader = new FilesystemLoader('templates');
        $twig = new Environment($loader);

        echo $twig->render('nav.html.twig', ['name' => 'John Doe','ROOT'=>ROOT, 'style'=>'http://localhost/sikal_achraf-youdemy/public']);
    }
}