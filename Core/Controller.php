<?php

namespace Core;

class Controller
{
    protected $view;
    protected $database;

    public function __construct()
    {
        session_start();

        $this->view = new View();

        /*
        $this->database = new Database(
            \App\Config::$database['server'],
            \App\Config::$database['host'],
            \App\Config::$database['name'],
            \App\Config::$database['charset'],
            \App\Config::$database['user_name'],
            \App\Config::$database['user_password'],
            \App\Config::$database['options']
        );
        */
    }
}