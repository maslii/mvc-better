<?php

namespace Core;

class AdminController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== 1) {
            header('Location: /auth');
            exit;
        }
    }
}