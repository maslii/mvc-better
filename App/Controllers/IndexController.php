<?php

namespace App\Controllers;

use Core\Controller;

class IndexController extends Controller
{
    public function index()
    {
        /*
        $model = new \App\Models\SliderModel($this->database->getConnection());
        $slider = $model->getImages();
        */

        $this->view->renderLayout(
            [
                'user/header',
                'user/index',
                'user/footer'
            ],
            'Home',
            'user/layout',
            [
                //'slider' => $slider
            ]
        );
    }
}