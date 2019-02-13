<?php

namespace Core;

class View
{
    protected $viewTitle;
    protected $viewData;
    protected $viewContent;

    public function renderLayout(array $views, string $title, string $layout, array $data = [])
    {
        $this->viewTitle = $title;
        $this->viewData = $data;

        array_walk_recursive($this->viewData, [$this, 'filter']);

        ob_start();

        foreach ($views as $view) {
            include_once $_SERVER['DOCUMENT_ROOT'] . '/App/Views/' . $view . '.php';
        }

        $this->viewContent = ob_get_clean();

        include_once $_SERVER['DOCUMENT_ROOT'] . '/App/Views/' . $layout . '.php';
    }

    protected function filter(&$value)
    {
        if (\is_string($value)) {
            $value = \filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
        }

        return $value;
    }
}