<?php
namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller {
    public function index() {
        $data = [
            'active_page' => 'home',
            'page_title' => 'CLD - Empowering Every Child to Learn Differently',
            'page_description' => 'Center for Learning Disabilities (CLD) - Empowering children with dyslexia, ADHD, and autism.'
        ];
        $this->view('home', $data);
    }

    public function about() {
        $data = [
            'active_page' => 'about',
            'page_title' => 'About CLD - Our Mission and Team'
        ];
        $this->view('about', $data);
    }

    public function services() {
        $data = [
            'active_page' => 'services',
            'page_title' => 'Our Services - CLD Assessment Programs'
        ];
        $this->view('services', $data);
    }
    
    public function resources() {
        $data = [
            'active_page' => 'resources',
            'page_title' => 'Resources - Learning Disability Support & Information'
        ];
        $this->view('resources', $data);
    }

    public function research() {
        $researchModel = $this->model('Research');
        $items = $researchModel->getAll();
        $data = [
            'active_page' => 'research',
            'page_title' => 'Research - CLD',
            'items' => $items
        ];
        $this->view('research', $data);
    }

    public function get_involved() {
        $data = [
            'active_page' => 'join-us',
            'page_title' => 'Join Us - CLD'
        ];
        $this->view('join_us', $data);
    }

    public function pricing() {
        $testModel = $this->model('Test');
        $tests = $testModel->getAllActive();

        $data = [
            'active_page' => 'pricing',
            'page_title' => 'Pricing & Assessment Packages - CLD',
            'page_description' => 'Transparent pricing for psycho-educational assessments, ADHD screenings, and learning support services.',
            'tests' => $tests
        ];
        $this->view('pricing', $data);
    }
}
