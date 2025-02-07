<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

class user extends controller{
    public function index(){
        $data['title'] = 'home';
        $this->view('users',$data);
        $loader = new FilesystemLoader('templates');
        $twig = new Environment($loader, [
            'debug' => true
        ]);
        $twig->addExtension(new DebugExtension());
        echo $twig->render('nav.html.twig', ['ROOT'=>ROOT, 'style'=>'http://localhost/sikal_achraf-youdemy/public']);
        return $twig;
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
                redirect('user/login');
            }
        }
        $data['title'] = 'signup';
        $_POST['role'] = 'writer';
        echo $this->index()->render('signup.html.twig', ['ROOT'=>ROOT, 'style'=>'http://localhost/sikal_achraf-youdemy/public']);
    }
    public function login()
    {
        $data['title'] = "login";
        $data['errors'] = [];
        $user= new userModel();
        if ($_SERVER["REQUEST_METHOD"]== "POST") {
                $row = $user->first(['email'=>$_POST['email']]);
                if ($row && password_verify((string) $_POST['password'],(string) $row['password'])) {
                    Auth::authenticate($row);
                    redirect('home');
                }
                $data['errors']['email']= "Wrong email or password";
        }
        echo $this->index()->render('login.html.twig', ['ROOT'=>ROOT, 'style'=>'http://localhost/sikal_achraf-youdemy/public','data'=>$data]);
    }
}