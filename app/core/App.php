<?php

class app {
    protected $controller= '_404';
    protected $method= 'index';
    public static $page = '_404';

    function __construct() {
        $arr = $this->geturl();
        $office = "front";
        $filename = file_exists(__DIR__."/../controllers/$office/".ucfirst($arr[0])."Controller.php") ? __DIR__."/../controllers/front/".ucfirst($arr[0])."Controller.php" : __DIR__."/../controllers/back/".ucfirst($arr[0])."Controller.php";
        if(file_exists($filename))
        {
            require $filename;
            $this->controller = $arr[0];
            self::$page = $arr[0];
            unset($arr[0]);
        }else {
            require __DIR__."/../controllers/".$this->controller.".php";
        }
        $myController = new $this->controller();
        $myMethod = $arr[1]??$this->method;
        if (!empty($arr[1])) 
        {
            if (method_exists($myController,strtolower($myMethod)))
            {
                $this->method = strtolower($myMethod);
                unset($arr[1]);
            }
        }
        $arr = array_values($arr);
        call_user_func_array([$myController,$this->method], $arr);
    }
    private function geturl() {
        $url = $_GET['url'] ?? 'home';
        $url = filter_var($url,FILTER_SANITIZE_URL);
        $arr = explode('/',$url);
        return $arr;
    }
}