<?php
/**
 * main controller class
 */
class Controller
{
    public function view($view,$data = []) {
        extract($data);
        $filename = "../app/view/front/".$view.".twig";
        if (file_exists($filename)) {
            require $filename;
        }else {
            echo "could not find view file".$filename;
        }
    }
}