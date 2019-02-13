<?php

namespace App\Controllers;

class AuthController extends \Core\Controller
{
    public function index()
    {
        if (isset($_SESSION['admin']) && $_SESSION['admin'] === 1) {
            header('Location: /admin');
            exit;
        }

        $this->view->renderLayout(
            [
                'admin/auth'
            ],
            'Login',
            'admin/layout'
        );
    }

    public function logout()
    {
        session_unset();
        header('Location: /');
        exit;
    }

    public function check()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new \Core\Exceptions\MethodNotAllowedException();
        }

        if (!isset($_POST['authUser'], $_POST['authPassword'])) {
            header('Location: /auth');
            exit();
        }

        $userName = trim($_POST['authUser']);
        $userPassword = trim($_POST['authPassword']);

        if (empty($userName) || empty($userPassword)) {
            header('Location: /auth');
            exit();
        }

        $userName = filter_var($userName, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW |FILTER_FLAG_STRIP_HIGH);

        if ($userName === false) {
            header('Location: /auth');
            exit;
        }

        $model = new \App\Models\UserModel($this->database->getConnection());
        $hash = $model->getPasswordHash($userName)['password_hash'];

        if (password_verify($userPassword, $hash)) {
            $_SESSION['admin'] = 1;

            if (password_needs_rehash($hash, PASSWORD_DEFAULT)) {
                $newHash = password_hash($userPassword, PASSWORD_DEFAULT);
                $model->updatePasswordHash($userName, $newHash);
            }

            header('Location: /admin');
            exit;
        }

        header('Location: /auth');
        exit;
    }
}