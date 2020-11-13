<?php

namespace App;

class Route
{

    private $curDir = __DIR__ . DIRECTORY_SEPARATOR . '..';

    private $actions = [];

    public function add($route, $action)
    {
        $this->actions[$route] = $action;
    }

    public function execute()
    {
        $sourceDir = '';
        try {

            $path = str_replace($sourceDir, '', $_SERVER['REQUEST_URI']);

            $path = explode('?', $path)[0];

            $action = explode('@', $this->actions[$path]);
            $route = $action[0];
            $actionMethod = $action[1] == '' ? 'index' : $action[1];

            $controllerClassName = 'App\\' . $route . 'Controller';

            $controller = new $controllerClassName;
            $controller->$actionMethod();

        } catch (\Exception $e) {
            //echo $e->getMessage();
            include $this->curDir . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . '404.php';
            exit;
        }
    }

}