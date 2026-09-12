<?php
namespace App\Core;

class Controller {
    public function model($model) {
        $modelClass = 'App\\Models\\' . $model;
        return new $modelClass();
    }

    public function view($view, $data = []) {
        extract($data);
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            die("View does not exist: " . $view);
        }
    }
}
