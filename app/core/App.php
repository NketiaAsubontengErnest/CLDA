<?php
namespace App\Core;

class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Check for plural controller name first
        if (isset($url[0]) && file_exists('../app/controllers/' . ucfirst($url[0]) . 'Controller.php')) {
            $this->controller = ucfirst($url[0]) . 'Controller';
            unset($url[0]);
            $url = array_values($url);
        } 
        // Check for singular controller name (e.g. Tests -> TestController)
        elseif (isset($url[0]) && file_exists('../app/controllers/' . ucfirst(rtrim($url[0], 's')) . 'Controller.php')) {
            $this->controller = ucfirst(rtrim($url[0], 's')) . 'Controller';
            unset($url[0]);
            $url = array_values($url);
        }

        $controllerClass = 'App\\Controllers\\' . $this->controller;
        $this->controller = new $controllerClass;

        if (isset($url[0])) {
            $methodName = str_replace('-', '_', $url[0]);
            if (method_exists($this->controller, $methodName)) {
                $this->method = $methodName;
                unset($url[0]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}
