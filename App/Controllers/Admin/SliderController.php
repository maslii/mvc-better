<?php

namespace App\Controllers\Admin;

class SliderController extends \Core\AdminController
{
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new \Core\Exceptions\MethodNotAllowedException();
        }

        //$model = new \App\Models\SliderModel($this->database->getConnection());

        $uploader = new \Core\Upload();

        $pathImage = $_SERVER['DOCUMENT_ROOT'] . '/public/assets/images/slider/';

        $result = $uploader->handle(
            $pathImage,
            'slider_image',
            \App\Config::$files['max_size'],
            [
                'jpg' => 'image/jpeg',
                'png' => 'image/png'
            ],
            'slider'
        );

        /*
        if ($result !== false) {
            $model->insertImage('/assets/images/slider/' . $result);
        }

        */

        header('Location: /admin/home');
        exit;
    }

}