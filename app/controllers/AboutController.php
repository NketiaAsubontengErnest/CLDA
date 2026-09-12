<?php
namespace App\Controllers;

use App\Core\Controller;

class AboutController extends Controller {
    public function index() {
        $data = [
            'active_page' => 'about',
            'page_title' => 'About CLD'
        ];
        $this->view('about', $data);
    }

    public function background() {
        $data = [
            'active_page' => 'about',
            'page_title' => 'Background - CLD'
        ];
        $this->view('about/background', $data);
    }

    public function mission() {
        $data = [
            'active_page' => 'about',
            'page_title' => 'Mission and Vision - CLD'
        ];
        $this->view('about/mission', $data);
    }

    public function commitment() {
        $data = [
            'active_page' => 'about',
            'page_title' => 'Our Commitment - CLD'
        ];
        $this->view('about/commitment', $data);
    }
}
