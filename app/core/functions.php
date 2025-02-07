<?php

function show($stuff): void {
    echo"<pre>";
    print_r($stuff);
    echo"</pre>";
}
function redirect(string $link): never
{
    header("Location: " . ROOT . "/" . $link);
    die;
}
function set_value($key, $default = '') {
    if (!empty($_POST[$key])) {
        return $_POST[$key];
    }elseif(!empty($default)) {
        return $default;
    }
    return '';
}
function set_select($key, $value,$default = ''): string {
    if (!empty($_POST[$key])) {
        if ($value==$_POST[$key]) {
            return ' selected ';
        }
    }elseif(!empty($default)) {
        if ($value==$default) {
            return ' selected ';
        }
    }
    return '';
}
function message($msg="", $erase=false) {
    if (!empty($msg)) {
        $_SESSION['message'] = $msg;
    } elseif (!empty($_SESSION['message'])) {
        $msg =  $_SESSION['message'];
        if ($erase) {
            unset($_SESSION['message']);
        }
        return $msg;
    }
    return false;
}
function esc($str): string {
    return nl2br(htmlspecialchars((string) $str));
}

function str_to_url(): ?string {
    $url = str_replace("'", "", $url);
    $url = preg_replace("~[^\\pL0-9_]+~u", "-", $url);
    $url = trim($url, "-");
    $url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
    $url = strtolower($url);
    return preg_replace("~[^-a-z0-9_]+~", "", $url);
}

function dd($stuff): never {
    echo"<pre>";
    var_dump($stuff);die;
}
function user_can(string $permission) : bool {
    $permission = strtolower($permission);
    if (auth::logged_in()) {
        $roles['student'] = ['edit_category','add_category'];
        $roles['teacher'] = ['edit_category','add_category'];
        $roles['admin'] = ['edit_category','add_category','delete_category'];
        $role = auth::get_role();
        if (in_array($permission, $rolse[$role])) {
            return true;
        }
    }
    return false;
}