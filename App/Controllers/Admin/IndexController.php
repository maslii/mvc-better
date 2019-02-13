<?php

namespace App\Controllers\Admin;

class IndexController extends \Core\AdminController
{
    public function index()
    {
        $model = new \App\Models\GalleryModel($this->database->getConnection());
        $menu_categories = $model->getCategories();

        $this->view->renderLayout(
            [
                'admin/header',
                'admin/index',
                'admin/footer'
            ],
            'Адміністративна частина',
            'admin/layout',
            [
                'menu_categories' => $menu_categories
            ]
        );
    }
}