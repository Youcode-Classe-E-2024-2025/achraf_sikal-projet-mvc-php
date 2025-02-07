<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

class user extends controller{
    public function index(){
        $data['title'] = 'home';
        $this->view('users',$data);
        $twigData = ['ROOT'=>ROOT, 'style'=>'http://localhost/sikal_achraf-youdemy/public'];
        if (isset($_SESSION['USER_DATA'])) {
            $twigData['USER_DATA'] = $_SESSION['USER_DATA'];
        }
        $loader = new FilesystemLoader('templates');
        $twig = new Environment($loader, [
            'debug' => true
        ]);
        $twig->addExtension(new DebugExtension());
        echo $twig->render('nav.html.twig', $twigData);
        return $twig;
    }
    public function signup($role=null)
    {
        $user= new userModel();
        if ($_SERVER["REQUEST_METHOD"]== "POST") {
            
            $result = $user->validate($_POST);
            if ($result) {
                $_POST['password'] = password_hash((string) $_POST['password'], PASSWORD_DEFAULT);
                $_POST['role'] = $role ? $role:'reader';
                $user->insert($_POST);
                
                message("Your account is successfuly created, Please login");
                redirect('user/login');
            }
        }
        $data['title'] = 'signup';
        echo $this->index()->render('signup.html.twig', ['ROOT'=>ROOT, 'style'=>'http://localhost/sikal_achraf-youdemy/public']);
    }
    public function login()
    {
        $data['title'] = "login";
        $data['errors'] = [];
        $twigData = ['ROOT'=>ROOT, 'style'=>'http://localhost/sikal_achraf-youdemy/public','data'=>$data];
        $user= new userModel();
        if ($_SERVER["REQUEST_METHOD"]== "POST") {
                $row = $user->first(['email'=>$_POST['email']]);
                if ($row && password_verify((string) $_POST['password'],(string) $row['password'])) {
                    Auth::authenticate($row);
                    $twigData = array_merge($twigData, auth::getfirstname());
                    $twigData = array_merge($twigData, auth::getlastname());
                    $twigData = array_merge($twigData, auth::getemail());
                    $twigData = array_merge($twigData, auth::getrole());
                    $twigData['USER_DATA'] = $_SESSION['USER_DATA'];
                    redirect('home');
                }
                else {
                    $twigData['data']['errors']['email']= "Wrong email or password";
                }

        }
        echo $this->index()->render('login.html.twig', $twigData);
    }
    public function logout() {
        auth::logout();
        redirect('home');
    }
}