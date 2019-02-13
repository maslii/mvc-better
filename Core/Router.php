<?php

namespace Core;

class Router
{
    protected $controllerDirName;
    protected $controllerName;
    protected $actionName;
    protected $actionParams;

    protected function splitUri(string $uri, bool $useDir)
    {
        $uriArray = trim($uri, '/');
        $uriArray = filter_var($uriArray, FILTER_SANITIZE_URL) ?? '';
        $uriArray = $uriArray === '' ? [] : explode('/', $uriArray);

        if ($useDir) {
            $this->controllerDirName = $uriArray[0] ?? 'index';
            $this->controllerName = $uriArray[1] ?? 'index';
            $this->actionName = $uriArray[2] ?? 'index';

            unset($uriArray[0], $uriArray[1], $uriArray[2]);
            $this->actionParams = array_values($uriArray);

            $this->controllerDirName = ucfirst($this->controllerDirName);
            $this->controllerName = ucfirst($this->controllerName) . 'Controller';
        } else {
            $this->controllerName = $uriArray[0] ?? 'index';
            $this->actionName = $uriArray[1] ?? 'index';

            unset($uriArray[0], $uriArray[1]);
            $this->actionParams = array_values($uriArray);

            $this->controllerName = ucfirst($this->controllerName) . 'Controller';
            $this->controllerDirName = null;
        }
    }

    public function __construct(string $uri)
    {
        $controller = null;

        $this->splitUri($uri, true);

        if (class_exists('\\App\\Controllers\\' . $this->controllerDirName . '\\' . $this->controllerName)) {
            $controller = '\\App\\Controllers\\' . $this->controllerDirName . '\\' . $this->controllerName;
        } else {
            $this->splitUri($uri, false);

            if (class_exists('\\App\\Controllers\\' . $this->controllerName)) {
                $controller = '\\App\\Controllers\\' . $this->controllerName;
            } else {
                throw new \Core\Exceptions\NotFoundException();
            }
        }

        $controller = new $controller();

        if (method_exists($controller, $this->actionName)) {
            \call_user_func_array([$controller, $this->actionName], $this->actionParams);
        } else {
            throw new \Core\Exceptions\NotFoundException();
        }
    }
}