<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class user extends controller{
    public function index(){
        $data['title'] = 'home';
        $this->view('users',$data);
        $loader = new FilesystemLoader('templates');
        $twig = new Environment($loader);
        echo $twig->render('nav.html.twig', ['ROOT'=>ROOT, 'style'=>'http://localhost/sikal_achraf-youdemy/public']);
        return new Environment($loader);
    }
    public function signup()
    {
        $user= new userModel();
        if ($_SERVER["REQUEST_METHOD"]== "POST") {
            
            $result = $user->validate($_POST);
            if ($result) {
                $_POST['password'] = password_hash((string) $_POST['password'], PASSWORD_DEFAULT);
                $user->insert($_POST);
                
                message("Your account is successfuly created, Please login");
                redirect('login');
            }
        }
        $data['title'] = 'signup';
        $_POST['role'] = 'writer';
        echo $this->index()->render('signup.html.twig', ['ROOT'=>ROOT, 'style'=>'http://localhost/sikal_achraf-youdemy/public']);
    }
    public function login()
    {
        echo $this->index()->render('login.html.twig', ['ROOT'=>ROOT, 'style'=>'http://localhost/sikal_achraf-youdemy/public']);
    }
}