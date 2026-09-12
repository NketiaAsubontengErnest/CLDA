<?php
namespace App\Controllers;

use App\Core\Controller;

class NewsController extends Controller {
    public function index() {
        $newsModel = $this->model('News');
        $news = $newsModel->getAll();
        $this->view('news/index', ['active_page' => 'news', 'page_title' => 'News/Events', 'news' => $news]);
    }

    public function details($id) {
        $newsModel = $this->model('News');
        $item = $newsModel->getById($id);
        
        if (!$item) {
            header('Location: ' . ROOT . '/news');
            exit;
        }

        $this->view('news/details', ['active_page' => 'news', 'page_title' => $item['title'], 'item' => $item]);
    }

    public function download() {
        $model = $this->model('Download');
        $items = $model->getAll();
        $data = ['active_page' => 'news', 'page_title' => 'Downloads', 'items' => $items];
        $this->view('news/download', $data);
    }

    public function media() {
        $mediaModel = $this->model('Media');
        $media = $mediaModel->getAll();
        $data = [
            'active_page' => 'news', 
            'page_title' => 'Photo & Video Gallery', 
            'media' => $media
        ];
        $this->view('news/media', $data);
    }

    public function events() {
        $eventModel = $this->model('Event');
        $events = $eventModel->getAll();
        $data = [
            'active_page' => 'news', 
            'page_title' => 'Upcoming Events', 
            'events' => $events
        ];
        $this->view('news/events', $data);
    }

    public function dyslexia_month() {
        $data = ['active_page' => 'news', 'page_title' => 'Dyslexia Awareness Month'];
        $this->view('news/dyslexia_month', $data);
    }
}
