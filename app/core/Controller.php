<?php
/**
 * main controller class
 */
class Controller
{
    public function view($view,$data = []) {
        extract($data);
        $filename = file_exists(__DIR__."/../views/front/".$view.".twig")?__DIR__."/../views/front/".$view.".twig":__DIR__."/../views/back/".$view.".twig";
        if (file_exists($filename)) {
            require $filename;
        }else {
            echo "could not find view file".$filename;
        }
    }
}