<?php 
/**
 * @var array $submission
 * @var array $answers
 */
require_once '../app/views/layout/header.php'; 
?>

<main class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5 no-print">
            <div>
                <h2 class="fw-bold text-dark">Submission Details</h2>
                <p class="text-muted mb-0">Test: <?php echo htmlspecialchars($submission['test_title']); ?></p>
            </div>
            <div class="d-flex gap-2">
                <a href="<?php echo ROOT; ?>/admin/submission_print/<?php echo $submission['id']; ?>" target="_blank" class="btn btn-primary px-4 rounded-pill fw-bold">
                    <i class="fas fa-print me-2"></i> Print/Export Report
                </a>
                <?php if ($submission['status'] == 'completed'): ?>
                <a href="<?php echo ROOT; ?>/admin/email_report/<?php echo $submission['id']; ?>" class="btn btn-success px-4 rounded-pill fw-bold" onclick="return confirm('Send the report link to the client via email?');">
                    <i class="fas fa-envelope me-2"></i> Email Report
                </a>
                <?php endif; ?>
                <a href="<?php echo ROOT; ?>/admin/test_submissions/<?php echo $submission['test_id']; ?>" class="btn btn-outline-secondary px-4 rounded-pill fw-bold">
                    <i class="fas fa-arrow-left me-2"></i> Back to Submissions
                </a>
            </div>
        </div>

        <?php if (isset($_GET['email_sent'])): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> Report link has been successfully emailed to the client.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="d-none d-print-block mb-4">
            <div class="report-header text-center position-relative pb-3 mb-4">
                <div class="d-flex justify-content-center align-items-center flex-column mb-3">
                    <img src="<?php echo ROOT; ?>/assets/img/logo.png" alt="Logo" style="height: 130px; margin-bottom: 10px;">
                    <h2 class="mb-1 fw-bold text-uppercase" style="color: #000000; font-size: 18px;">Center for Learning Disabilities</h2>
                    <div style="font-size: 0.95rem; line-height: 1.5; font-weight: 600;">
                        <p class="mb-0 text-dark"><i class="fas fa-map-marker-alt text-primary me-1"></i> First Floor Weija SCC Snnit-Block A3, New Weija Accra Ghana</p>
                        <p class="mb-0 text-dark"><i class="fas fa-phone text-primary me-1"></i> 0537021064, 0204101335 &nbsp;&nbsp;|&nbsp;&nbsp; <i class="fas fa-envelope text-primary me-1"></i> info@cldghana.com / cldaghana@gmail.com</p>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top border-primary text-center" style="border-top-width: 2px !important;">
                    <h3 class="fw-bold text-dark mb-1 text-uppercase" style="letter-spacing: 1px; font-size: 22px;">Assessment Report</h3>
                    <h5 class="text-muted fw-bold"><?php echo htmlspecialchars($submission['test_title']); ?></h5>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 py-3 fw-bold">User Information</div>
                    <div class="card-body">
                        <h6 class="fw-bold text-muted text-uppercase small mb-3">Filing Person</h6>
                        <p class="mb-1"><span class="fw-bold">Name:</span> <?php echo htmlspecialchars($submission['user_name']); ?></p>
                        <p class="mb-1"><span class="fw-bold">Email:</span> <?php echo htmlspecialchars($submission['user_email']); ?></p>
                        <p class="mb-1"><span class="fw-bold">Phone:</span> <?php echo htmlspecialchars($submission['user_phone']); ?></p>
                        <hr>
                        <h6 class="fw-bold text-muted text-uppercase small mb-3">Assessed Individual</h6>
                        <p class="mb-1"><span class="fw-bold">Filing For:</span> <?php echo htmlspecialchars($submission['filing_for'] ?? 'N/A'); ?></p>
                        <p class="mb-1"><span class="fw-bold">Name:</span> <?php echo htmlspecialchars($submission['assessed_name'] ?? 'N/A'); ?></p>
                        <p class="mb-1"><span class="fw-bold">Date of Birth:</span> <?php echo !empty($submission['dob']) ? date('F d, Y', strtotime($submission['dob'])) : 'N/A'; ?></p>
                        <p class="mb-1"><span class="fw-bold">Age:</span> <?php echo htmlspecialchars($submission['age'] ?? 'N/A'); ?></p>
                        <p class="mb-1"><span class="fw-bold">Gender:</span> <?php echo htmlspecialchars($submission['gender'] ?? 'N/A'); ?></p>
                        <?php if (!empty($submission['school_grade'])): ?>
                            <p class="mb-1"><span class="fw-bold">School Grade:</span> <?php echo htmlspecialchars($submission['school_grade']); ?></p>
                        <?php endif; ?>
                        <div class="mt-2">
                            <span class="fw-bold d-block mb-1">Reason for Assessment:</span>
                            <div class="p-2 bg-light rounded small"><?php echo nl2br(htmlspecialchars($submission['assessment_reason'] ?? 'N/A')); ?></div>
                        </div>
                        <hr>
                        <p class="mb-1"><span class="fw-bold">Submission Date:</span> <?php echo date('F d, Y H:i', strtotime($submission['created_at'])); ?></p>
                        <hr class="no-print">
                        <div class="no-print">
                            <form action="" method="POST" class="mt-3">
                                <input type="hidden" name="update_status" value="1">
                                <label class="form-label small fw-bold">Update Status</label>
                                <div class="input-group">
                                    <select name="status" class="form-select status-select">
                                        <option value="pending" <?php echo ($submission['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="paid" <?php echo ($submission['status'] == 'paid') ? 'selected' : ''; ?>>Paid</option>
                                        <option value="completed" <?php echo ($submission['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                    </select>
                                    <button type="submit" class="btn btn-outline-primary fw-bold">Update</button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="mt-4">
                             <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fw-bold small text-uppercase text-muted mb-0">Domain Score Summary</h6>
                                    <button class="btn btn-sm btn-outline-secondary no-print" onclick="downloadChart('domainRadarChart', 'domain_profile')"><i class="fas fa-download"></i></button>
                                </div>
                                <div style="position: relative; height: 300px; width: 100%;">
                                    <canvas id="domainRadarChart"></canvas>
                                </div>
                                <p class="small text-muted mt-2 text-center">Score distribution across all assessed domains.</p>
                            </div>
                        </div>
                        
                        <?php if ($submission['status'] == 'pending'): ?>
                        <div class="mt-3 no-print">
                            <button onclick="copyToClipboard('<?php echo ROOT; ?>/tests/complete/<?php echo $submission['id']; ?>', false)" class="btn btn-outline-warning w-100 fw-bold">
                                <i class="fas fa-link me-2"></i> Copy Payment Link
                            </button>
                        </div>
                        <?php endif; ?>

                        <?php if ($submission['status'] == 'completed'): ?>
                        <div class="mt-4 border-top pt-3 no-print">
                            <h6 class="fw-bold small text-uppercase text-muted mb-2">Share Report Link</h6>
                            <p class="small text-muted mb-2">Send link to client via SMS or WhatsApp:</p>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control bg-light" value="<?php echo ROOT; ?>/tests/report/<?php echo $submission['id']; ?>" readonly>
                                <button class="btn btn-outline-primary" type="button" onclick="copyToClipboard('<?php echo ROOT; ?>/tests/report/<?php echo $submission['id']; ?>', true)">
                                    <i class="fas fa-copy"></i> Copy
                                </button>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <!-- Results Analysis -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 py-3 fw-bold d-flex justify-content-between align-items-center">
                        <span>Result</span>
                        <input type="date" id="chartDate" class="form-control form-control-sm w-auto" value="<?php echo date('Y-m-d', strtotime($submission['created_at'])); ?>" readonly>
                    </div>
                    <div class="card-body">
                        <?php
                        $analysis = [];
                        $raw_scores_by_domain = [];
                        foreach ($answers as $ans) {
                            $sec = $ans['section'] ?: 'Unsectioned';
                            $sub = $ans['subsection'] ?: '';
                            
                            if (!isset($raw_scores_by_domain[$sec])) {
                                $raw_scores_by_domain[$sec] = [];
                            }
                            $raw_scores_by_domain[$sec][] = (int)$ans['score'];
                            
                            if (!isset($analysis[$sec])) {
                                $analysis[$sec] = [
                                    'total_items' => 0,
                                    'item_scores' => 0,
                                    'symptom_count' => 0,
                                    'subsections' => []
                                ];
                            }
                            
                            if ($sub) {
                                if (!isset($analysis[$sec]['subsections'][$sub])) {
                                    $analysis[$sec]['subsections'][$sub] = [
                                        'total_items' => 0,
                                        'item_scores' => 0,
                                        'symptom_count' => 0
                                    ];
                                }
                                $analysis[$sec]['subsections'][$sub]['total_items']++;
                                $analysis[$sec]['subsections'][$sub]['item_scores'] += $ans['score'];
                                if ($ans['score'] >= 2) {
                                    $analysis[$sec]['subsections'][$sub]['symptom_count']++;
                                }
                            }
                            
                            $analysis[$sec]['total_items']++;
                            $analysis[$sec]['item_scores'] += $ans['score'];
                            if ($ans['score'] >= 2) {
                                $analysis[$sec]['symptom_count']++;
                            }
                        }
                        

                        $section_notes = json_decode($submission['section_notes'] ?? '{}', true);
                        ?>

                        <?php if (isset($_GET['notes_saved'])): ?>
                            <div class="alert alert-success alert-dismissible fade show small py-2" role="alert">
                                Section notes saved successfully!
                                <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form action="" method="POST">
                            <input type="hidden" name="save_notes" value="1">
                            <div class="table-responsive mb-4">
                                <table class="table table-hover align-middle border-bottom">
                                    <thead style="background-color: #0d6efd !important; color: #ffffff !important;">
                                        <tr>
                                            <th class="text-start" style="width: 25%; font-size: 12px; color: #ffffff !important; background-color: #0d6efd !important;">Sections/Domain</th>
                                            <th class="text-center" style="font-size: 12px; color: #ffffff !important; background-color: #0d6efd !important;">Total Items</th>
                                            <th class="text-center" style="font-size: 12px; color: #ffffff !important; background-color: #0d6efd !important;">Cumulative Score</th>
                                            <th class="text-center" style="font-size: 12px; color: #ffffff !important; background-color: #0d6efd !important;">Item Scores</th>
                                            <th style="width: 30%; font-size: 12px; color: #ffffff !important; background-color: #0d6efd !important;">Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($analysis as $cat => $data): ?>
                                        <tr class="table-light">
                                            <td class="text-start fw-bold" style="font-size: 12px; color: #0d6efd;"><?php echo htmlspecialchars($cat); ?></td>
                                            <td class="text-center" style="font-size: 12px; color: #000000;"><?php echo $data['total_items']; ?></td>
                                            <td class="text-center" style="font-size: 12px; color: #000000;"><?php echo $data['item_scores']; ?></td>
                                            <td class="text-center" style="font-size: 12px; color: #000000;"><span style="border: 2px solid #dc3545; border-radius: 50%; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; color: #dc3545; font-weight: bold; font-size: 11px;"><?php echo $data['symptom_count']; ?></span></td>
                                            <td>
                                                <div class="d-none d-print-block small text-start" style="font-size: 12px; color: #000000;">
                                                    <?php echo nl2br(htmlspecialchars($section_notes[$cat] ?? '')); ?>
                                                </div>
                                                <textarea name="notes[<?php echo htmlspecialchars($cat); ?>]" class="form-control form-control-sm no-print" rows="2" placeholder="Add notes..." style="font-size: 12px; color: #000000;"><?php echo htmlspecialchars($section_notes[$cat] ?? ''); ?></textarea>
                                            </td>
                                        </tr>
                                        <?php if (!empty($data['subsections'])): ?>
                                            <?php foreach ($data['subsections'] as $subcat => $subdata): ?>
                                            <tr>
                                                <td class="text-start ps-4 small text-muted" style="font-size: 12px; color: #0d6efd;"><i class="fas fa-level-up-alt fa-rotate-90 me-2 no-print"></i><?php echo htmlspecialchars($subcat); ?></td>
                                                <td class="text-center" style="font-size: 12px; color: #000000;"><?php echo $subdata['total_items']; ?></td>
                                                <td class="text-center" style="font-size: 12px; color: #000000;"><?php echo $subdata['item_scores']; ?></td>
                                                <td class="text-center" style="font-size: 12px; color: #000000;"><span style="border: 2px solid #dc3545; border-radius: 50%; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; color: #dc3545; font-weight: bold; font-size: 11px;"><?php echo $subdata['symptom_count']; ?></span></td>
                                                <td>
                                                    <div class="d-none d-print-block small text-start" style="font-size: 12px; color: #000000;">
                                                        <?php echo nl2br(htmlspecialchars($section_notes[$cat . '::' . $subcat] ?? '')); ?>
                                                    </div>
                                                    <textarea name="notes[<?php echo htmlspecialchars($cat . '::' . $subcat); ?>]" class="form-control form-control-sm no-print" rows="1" placeholder="Subsection notes..." style="font-size: 12px; color: #000000;"><?php echo htmlspecialchars($section_notes[$cat . '::' . $subcat] ?? ''); ?></textarea>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <div class="text-end no-print">
                                    <button type="submit" class="btn btn-primary px-4 fw-bold rounded-pill">
                                        <i class="fas fa-save me-2"></i> Save Section Notes
                                    </button>
                                </div>
                            </div>
                        </form>

                        <small class="text-muted d-block mt-2 mb-4">
                            * <strong>Total Items</strong> refers to the number of questions in this section/domain.<br>
                            * <strong>Cumulative Score</strong> is the cumulative score for all items in the section.<br>
                            * <strong>Item Scores</strong> is the number of items with a score of 2 (Often) or 3 (Very Often).
                        </small>

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fw-bold small text-uppercase text-muted mb-0">Overall Score Distribution</h6>
                                    <button class="btn btn-sm btn-outline-secondary no-print" onclick="downloadChart('scoresChart', 'overall_scores')"><i class="fas fa-download"></i></button>
                                </div>
                                <div style="position: relative; height: 250px; width: 100%;">
                                    <canvas id="scoresChart"></canvas>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4 mt-2">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fw-bold small text-uppercase text-muted mb-0">Score Distribution</h6>
                                    <button class="btn btn-sm btn-outline-secondary no-print" onclick="downloadChart('boxplotChart', 'boxplot_scores')"><i class="fas fa-download"></i></button>
                                </div>
                                <div style="position: relative; height: 300px; width: 100%;">
                                    <canvas id="boxplotChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Client Responses -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 py-3 fw-bold">Detailed Responses</div>
                    <div class="card-body" id="clientResponsesContent">
                        <?php
                        $grouped_client_responses = [];
                        foreach ($answers as $ans) {
                            $sec = $ans['section'] ?: 'General';
                            $sub = $ans['subsection'] ?: '';
                            
                            if (!isset($grouped_client_responses[$sec])) {
                                $grouped_client_responses[$sec] = [
                                    'questions' => [],
                                    'subsections' => []
                                ];
                            }
                            
                            if ($sub) {
                                if (!isset($grouped_client_responses[$sec]['subsections'][$sub])) {
                                    $grouped_client_responses[$sec]['subsections'][$sub] = [];
                                }
                                $grouped_client_responses[$sec]['subsections'][$sub][] = $ans;
                            } else {
                                $grouped_client_responses[$sec]['questions'][] = $ans;
                            }
                        }
                        ?>

                        <?php 
                        $q_count = 1;
                        foreach ($grouped_client_responses as $section_name => $content): 
                        ?>
                            <div class="mb-5">
                                <h5 class="fw-bold p-3 rounded-3 mb-3 d-flex justify-content-between align-items-center text-dark" style="background-color: #f8f9fa; border-left: 5px solid #0d6efd;">
                                    <span><i class="fas fa-layer-group me-2 text-primary"></i> <?php echo htmlspecialchars($section_name); ?></span>
                                    <span class="badge bg-light text-dark border fw-normal small"><?php echo (count($content['questions']) + array_sum(array_map('count', $content['subsections']))); ?> Items</span>
                                </h5>
                                
                                <?php if (!empty($content['questions'])): ?>
                                    <div class="table-responsive mb-4">
                                        <table class="table table-hover align-middle border-bottom">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 65%; font-size: 12px; color: #000000;">Question</th>
                                                    <th class="text-center" style="font-size: 12px; color: #000000;">Response</th>
                                                    <th class="text-center" style="width: 10%; font-size: 12px; color: #000000;">Score</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($content['questions'] as $q): ?>
                                                    <tr>
                                                        <td class="py-3" style="font-size: 12px; color: #000000;">
                                                            <span class="me-2 fw-bold"><?php echo $q_count++; ?>.</span>
                                                            <?php echo htmlspecialchars($q['question_text']); ?>
                                                        </td>
                                                        <td class="text-center fw-bold" style="font-size: 12px; color: <?php echo ($q['score'] >= 2) ? '#dc3545' : '#0d6efd'; ?>;">
                                                            <?php echo htmlspecialchars($q['answer_text']); ?>
                                                        </td>
                                                        <td class="text-center" style="font-size: 12px;">
                                                            <?php if ($q['score'] >= 2): ?>
                                                                <span style="border: 1.5px solid #dc3545; border-radius: 50%; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; color: #dc3545; font-weight: bold;">
                                                                    <?php echo $q['score']; ?>
                                                                </span>
                                                            <?php else: ?>
                                                                <span style="font-weight: bold; color: #000000;">
                                                                    <?php echo $q['score']; ?>
                                                                </span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($content['subsections'])): ?>
                                    <?php foreach ($content['subsections'] as $subsection_name => $sub_questions): ?>
                                        <div class="ms-md-4 mb-4">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="flex-grow-1 border-bottom"></div>
                                                <h6 class="fw-bold text-muted text-uppercase small mb-0 px-3">
                                                    <i class="fas fa-level-down-alt fa-rotate-90 me-2"></i> <?php echo htmlspecialchars($subsection_name); ?>
                                                </h6>
                                                <div class="flex-grow-1 border-bottom"></div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-sm table-hover align-middle">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th style="width: 65%; font-size: 12px; color: #000000;">Question</th>
                                                            <th class="text-center" style="font-size: 12px; color: #000000;">Response</th>
                                                            <th class="text-center" style="width: 10%; font-size: 12px; color: #000000;">Score</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($sub_questions as $q): ?>
                                                            <tr>
                                                                <td class="py-2" style="font-size: 12px; color: #000000;">
                                                                    <span class="me-2 fw-bold"><?php echo $q_count++; ?>.</span>
                                                                    <?php echo htmlspecialchars($q['question_text']); ?>
                                                                </td>
                                                                <td class="text-center fw-bold" style="font-size: 12px; color: <?php echo ($q['score'] >= 2) ? '#dc3545' : '#0d6efd'; ?>;">
                                                                    <?php echo htmlspecialchars($q['answer_text']); ?>
                                                                </td>
                                                                <td class="text-center" style="font-size: 12px;">
                                                                    <?php if ($q['score'] >= 2): ?>
                                                                        <span style="border: 1.5px solid #dc3545; border-radius: 50%; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; color: #dc3545; font-weight: bold;">
                                                                            <?php echo $q['score']; ?>
                                                                        </span>
                                                                    <?php else: ?>
                                                                        <span style="font-weight: bold; color: #000000;">
                                                                            <?php echo $q['score']; ?>
                                                                        </span>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Assessment Footer -->
                <div class="card border-0 shadow-sm rounded-4 mb-5">
                    <div class="card-header bg-white border-0 py-3 fw-bold">Report</div>
                    <div class="card-body">
                        <?php if (isset($_GET['assessment_saved'])): ?>
                            <div class="alert alert-success alert-dismissible fade show small py-2 mb-4" role="alert">
                                Report saved successfully!
                                <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="" method="POST">
                            <input type="hidden" name="save_assessment" value="1">
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-muted">1. Overall Summary</label>
                                <div class="d-none d-print-block p-3 bg-light rounded-3 mb-2 border">
                                    <?php echo nl2br(htmlspecialchars($submission['overall_summary'] ?? 'No summary provided.')); ?>
                                </div>
                                <textarea name="overall_summary" class="form-control rounded-3 no-print" rows="4" placeholder="Enter overall summary of the assessment..."><?php echo htmlspecialchars($submission['overall_summary'] ?? ''); ?></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-muted">2. Recommendation</label>
                                <div class="d-none d-print-block p-3 bg-light rounded-3 mb-2 border">
                                    <?php echo nl2br(htmlspecialchars($submission['recommendations'] ?? 'No recommendations provided.')); ?>
                                </div>
                                <textarea name="recommendations" class="form-control rounded-3 no-print" rows="4" placeholder="Enter recommendations..."><?php echo htmlspecialchars($submission['recommendations'] ?? ''); ?></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-muted">3. Additional Comments</label>
                                <div class="d-none d-print-block p-3 bg-light rounded-3 mb-2 border">
                                    <?php echo nl2br(htmlspecialchars($submission['additional_comments'] ?? 'No additional comments.')); ?>
                                </div>
                                <textarea name="additional_comments" class="form-control rounded-3 no-print" rows="3" placeholder="Any additional comments..."><?php echo htmlspecialchars($submission['additional_comments'] ?? ''); ?></textarea>
                            </div>

                            <hr class="my-4 opacity-25">

                            <div class="bg-light p-4 rounded-4">
                                <h6 class="fw-bold mb-4 text-dark"><i class="fas fa-file-signature me-2"></i>Signature Footer</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Name of Assessment Officer</label>
                                        <input type="text" name="officer_name" class="form-control" value="<?php echo htmlspecialchars($submission['officer_name'] ?? ''); ?>" placeholder="Enter full name">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold">Date</label>
                                        <input type="date" name="assessment_date" class="form-control" value="<?php echo htmlspecialchars($submission['assessment_date'] ?? date('Y-m-d')); ?>">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label small fw-bold">Signature / Designation</label>
                                        <div class="d-none d-print-block border-bottom border-2 pt-2 pb-1 mb-2" style="min-height: 40px; border-style: dotted !important;">
                                            <?php echo nl2br(htmlspecialchars($submission['officer_signature'] ?? '')); ?>
                                        </div>
                                        <textarea name="officer_signature" class="form-control no-print" rows="2" placeholder="Digital signature or title/designation..."><?php echo htmlspecialchars($submission['officer_signature'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4 no-print">
                                <button type="submit" class="btn btn-dark px-5 py-2 fw-bold rounded-pill">
                                    <i class="fas fa-check-circle me-2"></i> Save Final Assessment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/@sgratzl/chartjs-chart-boxplot@4"></script>
<script>
function copyToClipboard(text, isReport = false) {
    navigator.clipboard.writeText(text).then(() => {
        alert(isReport ? 'Report link copied to clipboard!' : 'Payment link copied to clipboard!');
    });
}

function downloadChart(chartId, fileName) {
    var canvas = document.getElementById(chartId);
    if (!canvas) {
        alert("Chart not found.");
        return;
    }
    
    // Create a temporary link
    var link = document.createElement('a');
    link.download = fileName + '.png';
    link.href = canvas.toDataURL('image/png', 1.0);
    link.click();
}

document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('scoresChart').getContext('2d');
    const analysis = <?php echo json_encode($analysis ?? []); ?>;
    const labels = Object.keys(analysis);
    const data = labels.map(label => analysis[label].item_scores);
    const symptomData = labels.map(label => analysis[label].symptom_count);
    
    // Generate colors
    const backgroundColors = [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
    ];
    const borderColors = [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
    ];

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Score by Section',
                data: data,
                backgroundColor: backgroundColors.slice(0, labels.length),
                borderColor: borderColors.slice(0, labels.length),
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                    position: 'top',
                }
            }
        }
    });

    // --- Dynamic Domain Profile (Radar Chart) ---
    const domainRadarCtx = document.getElementById('domainRadarChart').getContext('2d');
    new Chart(domainRadarCtx, {
        type: 'radar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Item Scores',
                data: symptomData,
                fill: true,
                backgroundColor: 'rgba(13, 110, 253, 0.2)',
                borderColor: 'rgba(13, 110, 253, 1)',
                pointBackgroundColor: 'rgba(13, 110, 253, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(13, 110, 253, 1)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                r: {
                    angleLines: { display: true },
                    suggestedMin: 0,
                    ticks: { display: false }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });

    // --- Boxplot Chart ---
    const rawScores = <?php echo json_encode($raw_scores_by_domain ?? []); ?>;
    const boxplotLabels = Object.keys(rawScores);
    const boxplotDataValues = Object.values(rawScores);

    const boxCtx = document.getElementById('boxplotChart');
    if(boxCtx) {
        new Chart(boxCtx.getContext('2d'), {
            type: 'boxplot',
            data: {
                labels: boxplotLabels,
                datasets: [{
                    label: 'Score Distribution',
                    data: boxplotDataValues,
                    backgroundColor: 'rgba(0, 0, 0, 0.4)',
                    borderColor: 'rgba(0, 0, 0, 1)',
                    borderWidth: 1,
                    outlierBackgroundColor: '#dc3545',
                    itemBackgroundColor: '#000000'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }
});
</script>

<?php require_once '../app/views/layout/footer.php'; ?>
