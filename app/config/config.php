<?php

/**
 * Database config
 */
define('DBHOST', 'localhost');
define('DBNAME', 'projet_mvc_php');
define('DBUSER', 'postgres');
define('DBPASS', 'toor');
define('DB', 'pgsql');

define('APP_NAME', 'projet-mvc-php');

define('ROOT', 'http://localhost/projet-mvc-php/public');

const TABLES = "
create table if not exists article (
    id serial primary key ,
    titre varchar(100),
    description varchar(800)
);

create table if not exists users(
    id serial primary key ,
    firstname varchar(50),
    lastname varchar(50),
    email varchar(100),
    password varchar(100)
);
";