<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class home extends controller{
    public function index(){
        $db= new database();
        $db->createTable();
        $data = ['title'=>'home','ROOT'=>ROOT, 'style'=>'http://localhost/sikal_achraf-youdemy/public'];
        if (isset($_SESSION['USER_DATA'])) {
            $data['USER_DATA'] = $_SESSION['USER_DATA'];
        }
        $loader = new FilesystemLoader('templates');
        $twig = new Environment($loader);
        
        echo $twig->render('nav.html.twig',$data);
        $this->view('home',$data);
    }
}