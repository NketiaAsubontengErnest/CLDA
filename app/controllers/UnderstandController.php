<?php
namespace App\Controllers;

use App\Core\Controller;

class UnderstandController extends Controller {
    public function index() {
        $this->dyslexia();
    }

    public function dyslexia() {
        $data = ['active_page' => 'understand', 'page_title' => 'Understanding Dyslexia'];
        $this->view('understand/dyslexia', $data);
    }

    public function dysgraphia() {
        $data = ['active_page' => 'understand', 'page_title' => 'Understanding Dysgraphia'];
        $this->view('understand/dysgraphia', $data);
    }

    public function dyscalculia() {
        $data = ['active_page' => 'understand', 'page_title' => 'Understanding Dyscalculia'];
        $this->view('understand/dyscalculia', $data);
    }

    public function dyspraxia() {
        $data = ['active_page' => 'understand', 'page_title' => 'Understanding Dyspraxia'];
        $this->view('understand/dyspraxia', $data);
    }

    public function adhd() {
        $data = ['active_page' => 'understand', 'page_title' => 'Understanding ADHD'];
        $this->view('understand/adhd', $data);
    }

    public function visual_processing() {
        $data = ['active_page' => 'understand', 'page_title' => 'Visual Processing Deficit'];
        $this->view('understand/visual_processing', $data);
    }

    public function transition_planning() {
        $data = ['active_page' => 'understand', 'page_title' => 'Transition Planning'];
        $this->view('understand/transition_planning', $data);
    }

    public function gifted_students() {
        $data = ['active_page' => 'understand', 'page_title' => 'Gifted Students'];
        $this->view('understand/gifted_students', $data);
    }
}
