<?php
namespace App\Models;

use App\Core\Model;

class Test extends Model {
    public function getAll() {
        $stmt = $this->db->query("
            SELECT t.*, COUNT(s.id) as submissions_count 
            FROM tests t 
            LEFT JOIN submissions s ON t.id = s.test_id 
            GROUP BY t.id 
            ORDER BY t.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    public function getAllActive($search = null) {
        $sql = "SELECT * FROM tests WHERE is_active = 1";
        $params = [];
        
        if ($search) {
            $sql .= " AND (title LIKE :search OR tags LIKE :search)";
            $params['search'] = '%' . $search . '%';
        }
        
        $sql .= " ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function toggleStatus($id) {
        $stmt = $this->db->prepare("UPDATE tests SET is_active = NOT is_active WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM tests WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO tests (title, description, tags, price) VALUES (:title, :description, :tags, :price)");
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE tests SET title = :title, description = :description, tags = :tags, price = :price WHERE id = :id");
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM tests WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    // Questions
    public function getQuestions($test_id, $sortBySection = true) {
        $orderBy = $sortBySection ? "section_id ASC, subsection_id ASC, sort_order ASC, id ASC" : "sort_order ASC, id ASC";
        $stmt = $this->db->prepare("SELECT * FROM questions WHERE test_id = :test_id ORDER BY {$orderBy}");
        $stmt->execute(['test_id' => $test_id]);
        return $stmt->fetchAll();
    }

    public function addQuestion($data) {
        $stmt = $this->db->prepare("INSERT INTO questions (test_id, question_text, type, section, subsection, section_id, subsection_id, options, sort_order) VALUES (:test_id, :question_text, :type, :section, :subsection, :section_id, :subsection_id, :options, :sort_order)");
        return $stmt->execute($data);
    }

    public function updateQuestion($id, $data) {
        $stmt = $this->db->prepare("UPDATE questions SET question_text = :question_text, type = :type, section = :section, subsection = :subsection, section_id = :section_id, subsection_id = :subsection_id, options = :options, sort_order = :sort_order WHERE id = :id");
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function deleteQuestion($id) {
        $stmt = $this->db->prepare("DELETE FROM questions WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    
    public function getQuestion($id) {
        $stmt = $this->db->prepare("SELECT * FROM questions WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Submissions
    public function createSubmission($data) {
        $stmt = $this->db->prepare("INSERT INTO submissions (test_id, user_name, user_email, user_phone, filing_for, assessed_name, dob, age, gender, school_grade, assessment_reason, status) VALUES (:test_id, :user_name, :user_email, :user_phone, :filing_for, :assessed_name, :dob, :age, :gender, :school_grade, :assessment_reason, :status)");
        $stmt->execute($data);
        return $this->db->lastInsertId();
    }

    public function saveAnswer($data) {
        $stmt = $this->db->prepare("INSERT INTO answers (submission_id, question_id, answer_text, score) VALUES (:submission_id, :question_id, :answer_text, :score)");
        return $stmt->execute($data);
    }

    public function getSubmissions($test_id, $search = null) {
        $sql = "SELECT * FROM submissions WHERE test_id = :test_id";
        $params = ['test_id' => $test_id];
        
        if ($search) {
            $sql .= " AND (user_name LIKE :search OR user_email LIKE :search OR user_phone LIKE :search OR assessed_name LIKE :search)";
            $params['search'] = '%' . $search . '%';
        }
        
        $sql .= " ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function deleteSubmission($id) {
        $stmt = $this->db->prepare("DELETE FROM submissions WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function getSubmission($id) {
        $stmt = $this->db->prepare("SELECT s.*, t.title as test_title, t.price FROM submissions s JOIN tests t ON s.test_id = t.id WHERE s.id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getAnswers($submission_id) {
        $stmt = $this->db->prepare("
            SELECT a.*, q.question_text, q.type, q.section, q.subsection, q.section_id, q.subsection_id, q.options
            FROM answers a 
            JOIN questions q ON a.question_id = q.id 
            WHERE a.submission_id = :submission_id
            ORDER BY q.section_id ASC, q.subsection_id ASC, q.sort_order ASC
        ");
        $stmt->execute(['submission_id' => $submission_id]);
        return $stmt->fetchAll();
    }

    // Test Structure (Sections & Subsections)
    public function getSections($test_id) {
        $stmt = $this->db->prepare("SELECT * FROM test_sections WHERE test_id = :test_id ORDER BY sort_order ASC, name ASC");
        $stmt->execute(['test_id' => $test_id]);
        return $stmt->fetchAll();
    }

    public function getSection($id) {
        $stmt = $this->db->prepare("SELECT * FROM test_sections WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function addSection($data) {
        $stmt = $this->db->prepare("INSERT INTO test_sections (test_id, name, sort_order) VALUES (:test_id, :name, :sort_order)");
        return $stmt->execute($data);
    }

    public function deleteSection($id) {
        $stmt = $this->db->prepare("DELETE FROM test_sections WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function getSubsections($section_id) {
        $stmt = $this->db->prepare("SELECT * FROM test_subsections WHERE section_id = :section_id ORDER BY sort_order ASC, name ASC");
        $stmt->execute(['section_id' => $section_id]);
        return $stmt->fetchAll();
    }

    public function getSubsection($id) {
        $stmt = $this->db->prepare("SELECT * FROM test_subsections WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function addSubsection($data) {
        $stmt = $this->db->prepare("INSERT INTO test_subsections (section_id, name, sort_order) VALUES (:section_id, :name, :sort_order)");
        return $stmt->execute($data);
    }

    public function deleteSubsection($id) {
        $stmt = $this->db->prepare("DELETE FROM test_subsections WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    
    public function updateSubmissionStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE submissions SET status = :status WHERE id = :id");
        return $stmt->execute(['id' => $id, 'status' => $status]);
    }

    public function updateSubmissionNotes($id, $notes) {
        $stmt = $this->db->prepare("UPDATE submissions SET section_notes = :notes WHERE id = :id");
        return $stmt->execute(['id' => $id, 'notes' => $notes]);
    }

    public function updateAssessmentDetails($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE submissions 
            SET overall_summary = :overall_summary, 
                recommendations = :recommendations, 
                additional_comments = :additional_comments, 
                officer_name = :officer_name, 
                officer_signature = :officer_signature, 
                assessment_date = :assessment_date 
            WHERE id = :id
        ");
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function getUserHistory($email, $test_id) {
        $stmt = $this->db->prepare("
            SELECT s.* 
            FROM submissions s 
            WHERE s.user_email = :email AND s.test_id = :test_id AND s.status != 'pending'
            ORDER BY s.created_at ASC
        ");
        $stmt->execute(['email' => $email, 'test_id' => $test_id]);
        return $stmt->fetchAll();
    }

    public function getDistinctTags() {
        $stmt = $this->db->query("SELECT tags FROM tests WHERE is_active = 1 AND tags IS NOT NULL AND tags != ''");
        $results = $stmt->fetchAll();
        
        $all_tags = [];
        foreach ($results as $row) {
            $tags = explode(',', $row['tags']);
            foreach ($tags as $tag) {
                $trimmed = trim($tag);
                if (!empty($trimmed)) {
                    $all_tags[] = $trimmed;
                }
            }
        }
        
        return array_unique($all_tags);
    }
}
