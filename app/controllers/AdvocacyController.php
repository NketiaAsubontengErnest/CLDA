<?php
namespace App\Controllers;

use App\Core\Controller;

class AdvocacyController extends Controller {
    public function index() {
        $this->inclusive_education();
    }

    public function inclusive_education() {
        $data = ['active_page' => 'advocacy', 'page_title' => 'Inclusive Education'];
        $this->view('advocacy/inclusive_education', $data);
    }

    public function rights_protection() {
        $data = ['active_page' => 'advocacy', 'page_title' => 'Rights and Protection'];
        $this->view('advocacy/rights_protection', $data);
    }

    public function legislative_agenda() {
        $data = ['active_page' => 'advocacy', 'page_title' => 'Legislative Agenda'];
        $this->view('advocacy/legislative_agenda', $data);
    }
}
