<?php
namespace App\Controllers;

use App\Core\Controller;

class AdminController extends Controller {
    public function __construct() {
        session_start();
    }

    public function index() {
        if (!isset($_SESSION['admin_logged_in'])) {
            header('Location: ' . ROOT . '/admin/login');
            exit;
        }
        $this->view('admin/dashboard', ['active_page' => 'admin']);
    }

    public function login() {
        if (isset($_SESSION['admin_logged_in'])) {
            header('Location: ' . ROOT . '/admin');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $userModel = $this->model('User');
            $user = $userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                header('Location: ' . ROOT . '/admin');
                exit;
            } else {
                $data['error'] = 'Invalid credentials';
            }
        }

        $this->view('admin/login', $data ?? []);
    }

    public function logout() {
        session_destroy();
        header('Location: ' . ROOT . '/admin/login');
        exit;
    }

    public function profile() {
        $this->checkAuth();
        $userModel = $this->model('User');
        $user = $userModel->findByUsername($_SESSION['admin_username']);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $new_username = $_POST['username'];
            $new_password = $_POST['password'];
            $current_password = $_POST['current_password'];

            // Verify current password
            if (password_verify($current_password, $user['password'])) {
                $updateData = ['username' => $new_username];
                if (!empty($new_password)) {
                    $updateData['password'] = password_hash($new_password, PASSWORD_DEFAULT);
                }

                if ($userModel->update($user['id'], $updateData)) {
                    $_SESSION['admin_username'] = $new_username;
                    $data['success'] = 'Profile updated successfully';
                    $user = $userModel->findByUsername($new_username); // Refresh user data
                } else {
                    $data['error'] = 'Failed to update profile';
                }
            } else {
                $data['error'] = 'Incorrect current password';
            }
        }

        $this->view('admin/profile', ['active_page' => 'admin', 'user' => $user, 'message' => $data ?? []]);
    }

    public function news() {
        $this->checkAuth();
        $newsModel = $this->model('News');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload_news'])) {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $image_path = '';

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "uploads/news/";
                if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
                $file_name = time() . '_' . basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $file_name;
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_path = $target_file;
                }
            }

            $newsModel->create([
                'title' => $title,
                'content' => $content,
                'image_path' => $image_path
            ]);
            header('Location: ' . ROOT . '/admin/news?success=1');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_news'])) {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            $image_path = $_POST['current_image'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "uploads/news/";
                if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
                $file_name = time() . '_' . basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $file_name;
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_path = $target_file;
                }
            }

            $newsModel->update($id, [
                'title' => $title,
                'content' => $content,
                'image_path' => $image_path
            ]);
            header('Location: ' . ROOT . '/admin/news?updated=1');
            exit;
        }

        $news = $newsModel->getAll();
        $this->view('admin/news', ['active_page' => 'admin', 'news' => $news]);
    }

    public function research() {
        $this->checkAuth();
        $model = $this->model('Research');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload_research'])) {
            $file_path = $this->handleUpload('research');
            $model->create([
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'file_path' => $file_path
            ]);
            header('Location: ' . ROOT . '/admin/research?success=1'); exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_research'])) {
            $id = $_POST['id'];
            $file_path = $_POST['current_file'];
            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                $file_path = $this->handleUpload('research');
            }
            $model->update($id, [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'file_path' => $file_path
            ]);
            header('Location: ' . ROOT . '/admin/research?updated=1'); exit;
        }

        $items = $model->getAll();
        $this->view('admin/research', ['active_page' => 'admin', 'items' => $items]);
    }

    public function media() {
        $this->checkAuth();
        $model = $this->model('Media');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload_media'])) {
            $file_path = $this->handleUpload('media');
            $model->create([
                'title' => $_POST['title'],
                'type' => $_POST['type'],
                'file_path' => $file_path
            ]);
            header('Location: ' . ROOT . '/admin/media?success=1'); exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_media'])) {
            $id = $_POST['id'];
            $file_path = $_POST['current_file'];
            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                $file_path = $this->handleUpload('media');
            }
            $model->update($id, [
                'title' => $_POST['title'],
                'type' => $_POST['type'],
                'file_path' => $file_path
            ]);
            header('Location: ' . ROOT . '/admin/media?updated=1'); exit;
        }

        $items = $model->getAll();
        $this->view('admin/media', ['active_page' => 'admin', 'items' => $items]);
    }

    public function downloads() {
        $this->checkAuth();
        $model = $this->model('Download');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload_download'])) {
            $file_path = $this->handleUpload('downloads');
            $model->create([
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'file_path' => $file_path
            ]);
            header('Location: ' . ROOT . '/admin/downloads?success=1'); exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_download'])) {
            $id = $_POST['id'];
            $file_path = $_POST['current_file'];
            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                $file_path = $this->handleUpload('downloads');
            }
            $model->update($id, [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'file_path' => $file_path
            ]);
            header('Location: ' . ROOT . '/admin/downloads?updated=1'); exit;
        }

        $items = $model->getAll();
        $this->view('admin/downloads', ['active_page' => 'admin', 'items' => $items]);
    }

    public function events() {
        $this->checkAuth();
        $model = $this->model('Event');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload_event'])) {
            $model->create([
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'event_date' => $_POST['event_date'],
                'location' => $_POST['location']
            ]);
            header('Location: ' . ROOT . '/admin/events?success=1'); exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_event'])) {
            $id = $_POST['id'];
            $model->update($id, [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'event_date' => $_POST['event_date'],
                'location' => $_POST['location']
            ]);
            header('Location: ' . ROOT . '/admin/events?updated=1'); exit;
        }

        $items = $model->getAll();
        $this->view('admin/events', ['active_page' => 'admin', 'items' => $items]);
    }

    // ---------------- Revenue (walk-in + online transactions) ----------------

    public function revenue() {
        $this->checkAuth();
        $model = $this->model('Transaction');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_walkin'])) {
            $amount = (float)($_POST['amount'] ?? 0);
            if (trim($_POST['client_name'] ?? '') === '' || $amount <= 0) {
                header('Location: ' . ROOT . '/admin/revenue?error=invalid'); exit;
            }
            $txn = $model->createWalkIn($_POST);
            $result = \App\Core\Notifier::sendReceipt($txn);
            header('Location: ' . ROOT . '/admin/revenue?success=1&receipt=' . $result); exit;
        }

        $search = trim($_GET['q'] ?? '');
        $source = $_GET['source'] ?? '';
        $perPage = 10;
        $total = $model->count($search, $source);
        $totalPages = max(1, (int)ceil($total / $perPage));
        $page = min(max(1, (int)($_GET['page'] ?? 1)), $totalPages);

        $this->view('admin/revenue/index', [
            'active_page' => 'admin',
            'items' => $model->getAll($search, $source, $perPage, ($page - 1) * $perPage),
            'totals' => $model->totals(),
            'search' => $search, 'source' => $source,
            'page' => $page, 'totalPages' => $totalPages, 'total' => $total,
        ]);
    }

    public function revenue_resend($id) {
        $this->checkAuth();
        $txn = $this->model('Transaction')->find($id);
        $result = $txn ? \App\Core\Notifier::sendReceipt($txn) : 'failed';
        header('Location: ' . ROOT . '/admin/revenue?resent=' . $result);
        exit;
    }

    // ---------------- Employees & Payroll ----------------

    public function employees() {
        $this->checkAuth();
        $model = $this->model('Employee');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                if (isset($_POST['add_employee'])) {
                    $model->create($_POST);
                    header('Location: ' . ROOT . '/admin/employees?success=1'); exit;
                }
                if (isset($_POST['edit_employee'])) {
                    $model->update($_POST['id'], $_POST);
                    header('Location: ' . ROOT . '/admin/employees?updated=1'); exit;
                }
            } catch (\PDOException $e) {
                header('Location: ' . ROOT . '/admin/employees?error=' . ($e->getCode() == 23000 ? 'duplicate' : 'db')); exit;
            }
        }

        $search = trim($_GET['q'] ?? '');
        $items = $model->getAll($search);
        $this->view('admin/payroll/employees', ['active_page' => 'admin', 'items' => $items, 'search' => $search]);
    }

    public function employees_delete($id) {
        $this->checkAuth();
        $this->model('Employee')->delete($id);
        header('Location: ' . ROOT . '/admin/employees?deleted=1');
        exit;
    }

    public function payroll() {
        $this->checkAuth();
        $model = $this->model('Payroll');
        $month = $_GET['month'] ?? date('Y-m');
        if (!preg_match('/^\d{4}-\d{2}$/', $month)) $month = date('Y-m');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $month = preg_match('/^\d{4}-\d{2}$/', $_POST['month'] ?? '') ? $_POST['month'] : $month;
            if (isset($_POST['generate'])) {
                $n = $model->generate($month, $this->model('Employee'));
                header('Location: ' . ROOT . '/admin/payroll?month=' . $month . '&generated=' . $n); exit;
            }
            if (isset($_POST['adjust'])) {
                $model->adjust($_POST['id'], (float)$_POST['bonus'], (float)$_POST['other_deductions'], trim($_POST['notes'] ?? ''));
                header('Location: ' . ROOT . '/admin/payroll?month=' . $month . '&updated=1'); exit;
            }
        }

        $records = $model->getByMonth($month);
        $this->view('admin/payroll/index', ['active_page' => 'admin', 'records' => $records, 'month' => $month]);
    }

    public function payroll_paid($id) {
        $this->checkAuth();
        $model = $this->model('Payroll');
        $r = $model->find($id);
        $model->markPaid($id);
        header('Location: ' . ROOT . '/admin/payroll?month=' . ($r['pay_month'] ?? date('Y-m')) . '&updated=1');
        exit;
    }

    public function payroll_delete($id) {
        $this->checkAuth();
        $model = $this->model('Payroll');
        $r = $model->find($id);
        $model->delete($id); // only removes records generated within the last 24 hours
        $deleted = $r && !$model->find($id);
        header('Location: ' . ROOT . '/admin/payroll?month=' . ($r['pay_month'] ?? date('Y-m')) . ($deleted ? '&deleted=1' : '&locked=1'));
        exit;
    }

    public function payslip($id) {
        $this->checkAuth();
        $record = $this->model('Payroll')->find($id);
        if (!$record) { header('Location: ' . ROOT . '/admin/payroll'); exit; }
        $this->view('admin/payroll/payslip', ['record' => $record]);
    }

    public function news_delete($id) {
        $this->checkAuth();
        $this->model('News')->delete($id);
        header('Location: ' . ROOT . '/admin/news?deleted=1');
        exit;
    }

    public function research_delete($id) {
        $this->checkAuth();
        $this->model('Research')->delete($id);
        header('Location: ' . ROOT . '/admin/research?deleted=1');
        exit;
    }

    public function media_delete($id) {
        $this->checkAuth();
        $this->model('Media')->delete($id);
        header('Location: ' . ROOT . '/admin/media?deleted=1');
        exit;
    }

    public function downloads_delete($id) {
        $this->checkAuth();
        $this->model('Download')->delete($id);
        header('Location: ' . ROOT . '/admin/downloads?deleted=1');
        exit;
    }

    public function events_delete($id) {
        $this->checkAuth();
        $this->model('Event')->delete($id);
        header('Location: ' . ROOT . '/admin/events?deleted=1');
        exit;
    }

    public function submission_delete($id) {
        $this->checkAuth();
        $model = $this->model('Test');
        $submission = $model->getSubmission($id);
        $test_id = null;
        if ($submission) {
            $test_id = $submission['test_id'];
            $model->deleteSubmission($id);
        }
        if ($test_id) {
            header('Location: ' . ROOT . '/admin/test_submissions/' . $test_id . '?deleted=1');
        } else {
            header('Location: ' . ROOT . '/admin/tests');
        }
        exit;
    }

    private function handleUpload($subfolder) {
        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $target_dir = "uploads/" . $subfolder . "/";
            if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
            $file_name = time() . '_' . basename($_FILES["file"]["name"]);
            $target_file = $target_dir . $file_name;
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                return $target_file;
            }
        }
        return '';
    }

    public function tests() {
        $this->checkAuth();
        $model = $this->model('Test');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_test'])) {
            $model->create([
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'tags' => $_POST['tags'],
                'price' => $_POST['price']
            ]);
            header('Location: ' . ROOT . '/admin/tests?success=1'); exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_test'])) {
            $model->update($_POST['id'], [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'tags' => $_POST['tags'],
                'price' => $_POST['price']
            ]);
            header('Location: ' . ROOT . '/admin/tests?updated=1'); exit;
        }

        $search = trim($_GET['q'] ?? '');
        $perPage = 10;
        $total = $model->countAll($search);
        $totalPages = max(1, (int)ceil($total / $perPage));
        $page = min(max(1, (int)($_GET['page'] ?? 1)), $totalPages);
        $tests = $model->getAll($search, $perPage, ($page - 1) * $perPage);
        $this->view('admin/tests/index', [
            'active_page' => 'admin', 'tests' => $tests, 'search' => $search,
            'page' => $page, 'totalPages' => $totalPages, 'total' => $total
        ]);
    }

    public function tests_delete($id) {
        $this->checkAuth();
        $this->model('Test')->delete($id);
        header('Location: ' . ROOT . '/admin/tests?deleted=1');
        exit;
    }
    
    public function tests_toggle_status($id) {
        $this->checkAuth();
        $this->model('Test')->toggleStatus($id);
        header('Location: ' . ROOT . '/admin/tests?updated=1');
        exit;
    }

    public function test_questions($test_id) {
        $this->checkAuth();
        $model = $this->model('Test');
        $test = $model->find($test_id);

        if (!$test) {
            header('Location: ' . ROOT . '/admin/tests'); exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_question'])) {
            $options = null;
            if ($_POST['type'] == 'radio' || $_POST['type'] == 'checkbox') {
                $options_array = [];
                $raw_options = explode(',', $_POST['options']);
                foreach ($raw_options as $opt) {
                    $parts = explode(':', $opt);
                    if (count($parts) == 2) {
                        $options_array[] = ['text' => trim($parts[0]), 'score' => (int)trim($parts[1])];
                    } else {
                        $options_array[] = trim($opt);
                    }
                }
                $options = json_encode($options_array);
            }
            
            $section_name = 'General';
            $subsection_name = '';
            
            $section_id = !empty($_POST['section_id']) ? $_POST['section_id'] : null;
            $subsection_id = !empty($_POST['subsection_id']) ? $_POST['subsection_id'] : null;

            if ($section_id) {
                $section = $model->getSection($section_id);
                if ($section) $section_name = $section['name'];
            }
            if ($subsection_id) {
                $subsection = $model->getSubsection($subsection_id);
                if ($subsection) $subsection_name = $subsection['name'];
            }

            $sort_order = (int)($_POST['sort_order'] ?? 0);

            // If sort order is 0, auto-calculate next number to place it at the end
            if ($sort_order <= 0) {
                $questions = $model->getQuestions($test_id);
                foreach ($questions as $q) {
                    $q_sec = !empty($q['section_id']) ? $q['section_id'] : null;
                    $q_sub = !empty($q['subsection_id']) ? $q['subsection_id'] : null;
                    if ($q_sec == $section_id && $q_sub == $subsection_id) {
                        if ($q['sort_order'] >= $sort_order) {
                            $sort_order = $q['sort_order'] + 1;
                        }
                    }
                }
            }

            $model->addQuestion([
                'test_id' => $test_id,
                'question_text' => $_POST['question_text'],
                'type' => $_POST['type'],
                'section' => $section_name,
                'subsection' => $subsection_name,
                'section_id' => $section_id,
                'subsection_id' => $subsection_id,
                'options' => $options,
                'sort_order' => $sort_order
            ]);
            header('Location: ' . ROOT . '/admin/test_questions/' . $test_id . '?success=1'); exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_question'])) {
             $options = null;
            if ($_POST['type'] == 'radio' || $_POST['type'] == 'checkbox') {
                $options_array = [];
                $raw_options = explode(',', $_POST['options']);
                foreach ($raw_options as $opt) {
                    $parts = explode(':', $opt);
                    if (count($parts) == 2) {
                        $options_array[] = ['text' => trim($parts[0]), 'score' => (int)trim($parts[1])];
                    } else {
                        $options_array[] = trim($opt);
                    }
                }
                $options = json_encode($options_array);
            }
            
            $section_name = 'General';
            $subsection_name = '';
            
            $section_id = !empty($_POST['section_id']) ? $_POST['section_id'] : null;
            $subsection_id = !empty($_POST['subsection_id']) ? $_POST['subsection_id'] : null;

            if ($section_id) {
                $section = $model->getSection($section_id);
                if ($section) $section_name = $section['name'];
            }
            if ($subsection_id) {
                $subsection = $model->getSubsection($subsection_id);
                if ($subsection) $subsection_name = $subsection['name'];
            }

            $model->updateQuestion($_POST['question_id'], [
                'question_text' => $_POST['question_text'],
                'type' => $_POST['type'],
                'section' => $section_name,
                'subsection' => $subsection_name,
                'section_id' => $section_id,
                'subsection_id' => $subsection_id,
                'options' => $options,
                'sort_order' => $_POST['sort_order'] ?? 0
            ]);
             header('Location: ' . ROOT . '/admin/test_questions/' . $test_id . '?updated=1'); exit;
        }

        $sections = $model->getSections($test_id) ?: [];
        $subsections_map = [];
        foreach ($sections as $sec) {
            $subsections_map[$sec['id']] = $model->getSubsections($sec['id']) ?: [];
        }

        $questions = $model->getQuestions($test_id, false) ?: [];
        
        // --- AUTO-LINKER: Repair existing questions that have names but no IDs ---
        $needs_refresh = false;
        foreach ($questions as $q) {
            if (empty($q['section_id']) && !empty($q['section'])) {
                foreach ($sections as $sec) {
                    if (trim(strtolower($sec['name'])) == trim(strtolower($q['section']))) {
                        // Found a section match, now try to find a subsection match
                        $sub_id = null;
                        if (!empty($q['subsection'])) {
                            foreach ($subsections_map[$sec['id']] as $sub) {
                                if (trim(strtolower($sub['name'])) == trim(strtolower($q['subsection']))) {
                                    $sub_id = $sub['id'];
                                    break;
                                }
                            }
                        }
                        $model->updateQuestion($q['id'], [
                            'section_id' => $sec['id'],
                            'subsection_id' => $sub_id
                        ]);
                        $needs_refresh = true;
                        break;
                    }
                }
            }
        }
        if ($needs_refresh) $questions = $model->getQuestions($test_id, false) ?: [];
        // ------------------------------------------------------------------------

        $this->view('admin/tests/questions', [
            'active_page' => 'admin', 
            'test' => $test, 
            'questions' => $questions,
            'sections' => $sections,
            'subsections_map' => $subsections_map
        ]);
    }

    public function test_sections($test_id) {
        $this->checkAuth();
        $model = $this->model('Test');
        $test = $model->find($test_id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_section'])) {
            $model->addSection([
                'test_id' => $test_id,
                'name' => $_POST['name'],
                'sort_order' => $_POST['sort_order'] ?? 0
            ]);
            header('Location: ' . ROOT . '/admin/test_sections/' . $test_id . '?success=1'); exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_subsection'])) {
            $model->addSubsection([
                'section_id' => $_POST['section_id'],
                'name' => $_POST['name'],
                'sort_order' => $_POST['sort_order'] ?? 0
            ]);
            header('Location: ' . ROOT . '/admin/test_sections/' . $test_id . '?success=1'); exit;
        }

        $sections = $model->getSections($test_id);
        $sections_with_subs = [];
        foreach ($sections as $sec) {
            $sec['subsections'] = $model->getSubsections($sec['id']);
            $sections_with_subs[] = $sec;
        }

        $this->view('admin/tests/sections', [
            'active_page' => 'admin', 
            'test' => $test, 
            'sections' => $sections_with_subs
        ]);
    }

    public function section_delete($test_id, $id) {
        $this->checkAuth();
        $this->model('Test')->deleteSection($id);
        header('Location: ' . ROOT . '/admin/test_sections/' . $test_id . '?deleted=1');
        exit;
    }

    public function subsection_delete($test_id, $id) {
        $this->checkAuth();
        $this->model('Test')->deleteSubsection($id);
        header('Location: ' . ROOT . '/admin/test_sections/' . $test_id . '?deleted=1');
        exit;
    }

    public function question_delete($test_id, $question_id) {
        $this->checkAuth();
        $this->model('Test')->deleteQuestion($question_id);
        header('Location: ' . ROOT . '/admin/test_questions/' . $test_id . '?deleted=1');
        exit;
    }

    public function test_submissions($test_id) {
        $this->checkAuth();
        $model = $this->model('Test');
        $test = $model->find($test_id);
        $search = $_GET['q'] ?? null;
        $submissions = $model->getSubmissions($test_id, $search);
        $this->view('admin/tests/submissions', [
            'active_page' => 'admin', 
            'test' => $test, 
            'submissions' => $submissions,
            'search' => $search
        ]);
    }

    public function submission_view($id) {
        $this->checkAuth();
        $model = $this->model('Test');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
            $model->updateSubmissionStatus($id, $_POST['status']);
            header('Location: ' . ROOT . '/admin/submission_view/' . $id . '?updated=1');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_notes'])) {
            $notes = json_encode($_POST['notes']);
            $model->updateSubmissionNotes($id, $notes);
            header('Location: ' . ROOT . '/admin/submission_view/' . $id . '?notes_saved=1');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_assessment'])) {
            $data = [
                'overall_summary' => $_POST['overall_summary'],
                'recommendations' => $_POST['recommendations'],
                'additional_comments' => $_POST['additional_comments'],
                'officer_name' => $_POST['officer_name'],
                'officer_signature' => $_POST['officer_signature'],
                'assessment_date' => $_POST['assessment_date']
            ];
            $model->updateAssessmentDetails($id, $data);
            header('Location: ' . ROOT . '/admin/submission_view/' . $id . '?assessment_saved=1');
            exit;
        }

        $submission = $model->getSubmission($id);
        $answers = $model->getAnswers($id);

        $this->view('admin/tests/submission_view', [
            'active_page' => 'admin', 
            'submission' => $submission, 
            'answers' => $answers
        ]);
    }

    public function submission_print($id) {
        $this->checkAuth();
        $model = $this->model('Test');

        $submission = $model->getSubmission($id);
        $answers = $model->getAnswers($id);

        if (!$submission) {
            header('Location: ' . ROOT . '/admin/tests');
            exit;
        }

        // We don't use the standard layout for printing
        $this->view('admin/tests/submission_print', [
            'submission' => $submission, 
            'answers' => $answers
        ]);
    }

    public function email_report($id) {
        $this->checkAuth();
        $model = $this->model('Test');
        $submission = $model->getSubmission($id);
        
        if (!$submission || $submission['status'] != 'completed') {
             header('Location: ' . ROOT . '/admin/tests'); exit;
        }

        $client_email = $submission['user_email'];
        $client_name = $submission['user_name'];
        $test_title = $submission['test_title'];
        $report_url = ROOT . '/tests/report/' . $id;

        $subject = "PRIVATE AND CONFIDENTIAL: Your Assessment Report";
        
        $body = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; color: #333; border: 1px solid #eee; border-radius: 8px; overflow: hidden;'>
            <div style='background-color: #ffffff; padding: 20px; text-align: center; border-bottom: 2px solid #0d6efd;'>
                <img src='" . ROOT . "/assets/img/logo.png' alt='Center for Learning Disabilities' style='height: 80px; margin-bottom: 10px;'>
                <h2 style='margin: 0; color: #000; font-size: 20px;'>Center for Learning Disabilities</h2>
            </div>
            <div style='text-align: center; font-weight: bold; margin-top: 20px; font-size: 12px; letter-spacing: 1px; color: #dc3545;'>
                PRIVATE AND CONFIDENTIAL
            </div>
            <div style='padding: 20px 30px;'>
                <p>Dear " . htmlspecialchars($client_name) . ",</p>
                <p>Your assessment report for the <strong>" . htmlspecialchars($test_title) . "</strong> has been finalized and is ready.</p>
                <p>Please click the button below to view and download your complete assessment report.</p>
                <div style='text-align: center; margin: 30px 0;'>
                    <a href='" . $report_url . "' style='background-color: #0d6efd; color: white; text-decoration: none; padding: 14px 30px; border-radius: 50px; font-weight: bold; display: inline-block;'>Download Assessment Report</a>
                </div>
                <p style='color: #666; font-size: 13px; text-align: justify; margin-top: 30px;'>
                    <strong>Disclaimer:</strong> Results should always be understood in the proper context and are not intended to be used as the sole basis for diagnosis.
                </p>
                <hr style='border: none; border-top: 1px solid #eee; margin: 30px 0;'>
                <p style='font-size: 14px;'>If you have any questions or feedback, our customer success team is eager to assist. Simply reply to this email, and we'll be right with you.</p>
                <p style='font-size: 14px;'>Kind Regards,<br><strong>The Center for Learning Disabilities Team</strong></p>
            </div>
            <div style='background-color: #f8f9fa; padding: 20px; text-align: center; font-style: italic; color: #666; font-size: 13px;'>
                Center for Learning Disabilities's mission is to help children with learning differences thrive through comprehensive assessment and support.
            </div>
        </div>
        ";

        $this->sendEmail($client_email, $client_name, $subject, $body);

        header('Location: ' . ROOT . '/admin/submission_view/' . $id . '?email_sent=1');
        exit;
    }

    private function sendEmail($to_email, $to_name, $subject, $body) {
        require_once '../public/phpmailer/Exception.php';
        require_once '../public/phpmailer/PHPMailer.php';
        require_once '../public/phpmailer/SMTP.php';

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'cldaghana@gmail.com'; 
            $mail->Password   = 'tcod eiqx fjib gqnq';
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('cldaghana@gmail.com', 'Center for Learning Disabilities');
            $mail->addAddress($to_email, $to_name); 

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function checkAuth() {
        if (!isset($_SESSION['admin_logged_in'])) {
            header('Location: ' . ROOT . '/admin/login');
            exit;
        }
    }
    public function settings() {
        $this->checkAuth();
        $model = $this->model('Setting');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_settings'])) {
            $model->set('paystack_public_key', $_POST['paystack_public_key']);
            $model->set('paystack_secret_key', $_POST['paystack_secret_key']);
            // Receipt delivery settings
            foreach (['sms_sender_id', 'smtp_host', 'smtp_port', 'smtp_username'] as $k) {
                $model->set($k, trim($_POST[$k] ?? ''));
            }
            // Secrets: a blank field keeps the stored value
            foreach (['sms_api_key', 'smtp_password'] as $k) {
                if (trim($_POST[$k] ?? '') !== '') $model->set($k, trim($_POST[$k]));
            }
            header('Location: ' . ROOT . '/admin/settings?success=1');
            exit;
        }

        $allSettings = $model->getAll();
        $settings = [];
        foreach ($allSettings as $s) {
            $settings[$s['setting_key']] = $s['setting_value'];
        }

        $this->view('admin/settings', ['active_page' => 'admin', 'settings' => $settings]);
    }
}
