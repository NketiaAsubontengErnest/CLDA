<?php
/**
 * @var array $submission
 * @var array $answers
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessment Report - <?php echo htmlspecialchars($submission['assessed_name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            color: #000000;
            background-color: white;
            padding: 0;
            margin: 0;
            font-size: 12px;
        }
        
        .print-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px;
        }
        
        .report-header {
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .report-title {
            color: #000000;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .section-title {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-left: 5px solid #0d6efd;
            font-weight: 700;
            margin-top: 30px;
            margin-bottom: 20px;
            page-break-after: avoid;
            font-size: 14px;
        }
        
        .info-label {
            font-weight: 600;
            color: #000000;
            width: 180px;
            display: inline-block;
        }
        
        .table-custom th {
            background-color: #f8f9fa;
            color: #000000;
            font-weight: 700;
            border-bottom: 2px solid #000000;
        }
        
        .score-badge {
            padding: 5px 12px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 11px;
        }
        
        .chart-container {
            margin: 30px 0;
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 12px;
        }
        
        .notes-box {
            background-color: #fdfdfd;
            border: 1px solid #eee;
            padding: 15px;
            border-radius: 8px;
            font-style: italic;
            font-size: 12px;
            color: #000000;
        }
        
        .signature-section {
            margin-top: 50px;
            padding-top: 30px;
            border-top: 1px solid #ddd;
        }
        
        .signature-line {
            border-bottom: 1px solid #000000;
            width: 250px;
            margin-bottom: 10px;
        }

        h1, h2, h3, h4, h5, h6 {
            color: #000000;
        }
        
        @media print {
            body {
                background-color: white;
                color: #000000 !important;
                font-size: 12px !important;
            }
            .text-muted, .text-secondary, .text-dark {
                color: #000000 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-container {
                width: 100%;
                max-width: none;
                padding: 20px;
            }
            .section-title {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                background-color: #f8f9fa !important;
            }
            table thead[style*="background-color: #0d6efd"] th {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                background-color: #0d6efd !important;
                color: #ffffff !important;
                border-color: #0d6efd !important;
            }
            table:not(.table-hover) th {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                background-color: #f8f9fa !important;
                color: #000000 !important;
                border-bottom: 2px solid #000000 !important;
            }
            .page-break {
                page-break-before: always;
            }
            .watermark {
                opacity: 0.08 !important;
            }
        }
        
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.05;
            z-index: -100;
            width: 80%;
            max-width: 600px;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <img src="<?php echo ROOT; ?>/assets/img/logo.png" alt="Watermark" class="watermark no-print" style="display: block;">
    <!-- For printing, ensuring watermark shows on all pages in standard browsers by using position fixed -->
    <img src="<?php echo ROOT; ?>/assets/img/logo.png" alt="Watermark" class="watermark d-none d-print-block">
    
    <div class="no-print bg-dark text-white p-3 text-center sticky-top shadow">
        <button onclick="window.print()" class="btn btn-primary px-5 rounded-pill fw-bold me-3">
            <i class="fas fa-print me-2"></i> Print Report
        </button>
        <button onclick="window.close()" class="btn btn-outline-light px-4 rounded-pill fw-bold">
            Close Window
        </button>
    </div>

    <div class="print-container">
        <div class="report-header text-center position-relative">
            <div class="d-flex justify-content-center align-items-center flex-column mb-3">
                <img src="<?php echo ROOT; ?>/assets/img/logo.png" alt="Logo" style="height: 130px; margin-bottom: 10px;">
                <h2 class="mb-1 fw-bold text-uppercase" style="color: #000000; font-size: 18px;">Center for Learning Disabilities</h2>
                <div style="font-size: 0.95rem; line-height: 1.5; font-weight: 600;">
                    <p class="mb-0 text-dark"><i class="fas fa-map-marker-alt text-primary me-1"></i> First Floor Weija SCC Snnit-Block A3, New Weija Accra Ghana</p>
                    <p class="mb-0 text-dark"><i class="fas fa-phone text-primary me-1"></i> 0537021064, 0204101335 &nbsp;&nbsp;|&nbsp;&nbsp; <i class="fas fa-envelope text-primary me-1"></i> info@cldghana.com / cldaghana@gmail.com</p>
                </div>
            </div>
            <div class="mt-4 pt-3 border-top border-primary text-center" style="border-top-width: 2px !important;">
                <h3 class="report-title mb-1 text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 22px;">Assessment Report</h3>
                <h5 class="text-muted fw-bold"><?php echo htmlspecialchars($submission['test_title']); ?></h5>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <h6 class="fw-bold text-uppercase text-muted small mb-3">Assessed Individual</h6>
                <p class="mb-2"><span class="info-label">Name:</span> <?php echo htmlspecialchars($submission['assessed_name'] ?? 'N/A'); ?></p>
                <p class="mb-2"><span class="info-label">Date of Birth:</span> <?php echo !empty($submission['dob']) ? date('F d, Y', strtotime($submission['dob'])) : 'N/A'; ?></p>
                <p class="mb-2"><span class="info-label">Age/Gender:</span> <?php echo htmlspecialchars($submission['age'] ?? 'N/A'); ?> / <?php echo htmlspecialchars($submission['gender'] ?? 'N/A'); ?></p>
                <p class="mb-2"><span class="info-label">School Grade:</span> <?php echo htmlspecialchars($submission['school_grade'] ?? 'N/A'); ?></p>
            </div>
            <div class="col-6">
                <h6 class="fw-bold text-uppercase text-muted small mb-3">Filing Information</h6>
                <p class="mb-2"><span class="info-label">Filing Person:</span> <?php echo htmlspecialchars($submission['user_name']); ?></p>
                <p class="mb-2"><span class="info-label">Relationship:</span> <?php echo htmlspecialchars($submission['filing_for'] ?? 'N/A'); ?></p>
                <p class="mb-2"><span class="info-label">Submission Date:</span> <?php echo date('F d, Y', strtotime($submission['created_at'])); ?></p>
            </div>
        </div>

        <div class="mt-4">
            <h6 class="fw-bold text-uppercase text-muted small mb-2">Reason for Assessment</h6>
            <div class="p-3 bg-light rounded border-start border-4 border-secondary">
                <?php echo nl2br(htmlspecialchars($submission['assessment_reason'] ?? 'N/A')); ?>
            </div>
        </div>

        <h5 class="section-title">Domain Score Summary</h5>
        <div style="display: table; width: 100%; table-layout: fixed; margin-bottom: 20px;">
            <div style="display: table-cell; width: 55%; padding-right: 10px; vertical-align: top;">
                <div class="chart-container" style="margin-top: 0; padding: 10px;">
                    <canvas id="domainRadarChart" height="250"></canvas>
                </div>
            </div>
            <div style="display: table-cell; width: 45%; padding-left: 10px; vertical-align: top;">
                <div class="chart-container" style="margin-top: 0; padding: 10px;">
                    <canvas id="scoresChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="chart-container">
                    <canvas id="boxplotChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <h5 class="section-title">Result</h5>
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
                $analysis[$sec] = ['total' => 0, 'score' => 0, 'symptoms' => 0, 'subsections' => []];
            }
            if ($sub) {
                if (!isset($analysis[$sec]['subsections'][$sub])) {
                    $analysis[$sec]['subsections'][$sub] = ['total' => 0, 'score' => 0, 'symptoms' => 0];
                }
                $analysis[$sec]['subsections'][$sub]['total']++;
                $analysis[$sec]['subsections'][$sub]['score'] += $ans['score'];
                if ($ans['score'] >= 2) $analysis[$sec]['subsections'][$sub]['symptoms']++;
            }
            $analysis[$sec]['total']++;
            $analysis[$sec]['score'] += $ans['score'];
            if ($ans['score'] >= 2) $analysis[$sec]['symptoms']++;
        }
        $section_notes = json_decode($submission['section_notes'] ?? '{}', true);
        ?>

        <table class="table table-hover align-middle border-bottom">
            <thead style="background-color: #0d6efd !important; color: #ffffff !important;">
                <tr>
                    <th class="text-start" style="font-size: 12px; color: #ffffff !important; background-color: #0d6efd !important;">Domain / Section</th>
                    <th class="text-center" style="font-size: 12px; color: #ffffff !important; background-color: #0d6efd !important;">Total Items</th>
                    <th class="text-center" style="font-size: 12px; color: #ffffff !important; background-color: #0d6efd !important;">Cumulative Score</th>
                    <th class="text-center" style="font-size: 12px; color: #ffffff !important; background-color: #0d6efd !important;">Item Scores</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($analysis as $cat => $data): ?>
                <tr class="table-light">
                    <td class="text-start fw-bold" style="font-size: 12px; color: #0d6efd;"><?php echo htmlspecialchars($cat); ?></td>
                    <td class="text-center" style="font-size: 12px; color: #000000;"><?php echo $data['total']; ?></td>
                    <td class="text-center" style="font-size: 12px; color: #000000;"><?php echo $data['score']; ?></td>
                    <td class="text-center" style="font-size: 12px; font-weight: bold; color: #000000;"><span style="border: 2px solid #dc3545; border-radius: 50%; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; color: #dc3545; font-weight: bold; font-size: 11px;"><?php echo $data['symptoms']; ?></span></td>
                </tr>
                <?php if (!empty($data['subsections'])): ?>
                    <?php foreach ($data['subsections'] as $subcat => $subdata): ?>
                    <tr>
                        <td class="text-start ps-4" style="font-size: 12px; color: #0d6efd;"><i class="fas fa-level-up fa-rotate-90 me-2"></i><?php echo htmlspecialchars($subcat); ?></td>
                        <td class="text-center" style="font-size: 12px; color: #000000;"><?php echo $subdata['total']; ?></td>
                        <td class="text-center" style="font-size: 12px; color: #000000;"><?php echo $subdata['score']; ?></td>
                        <td class="text-center" style="font-size: 12px; font-weight: bold; color: #000000;"><span style="border: 2px solid #dc3545; border-radius: 50%; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; color: #dc3545; font-weight: bold; font-size: 11px;"><?php echo $subdata['symptoms']; ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if (!empty($section_notes[$cat])): ?>
                <tr>
                    <td colspan="4" class="text-start p-3 bg-white" style="font-size: 12px; color: #000000;">
                        <div class="fw-bold text-muted mb-1 small text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">NOTES:</div>
                        <?php echo nl2br(htmlspecialchars($section_notes[$cat])); ?>
                    </td>
                </tr>
                <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h5 class="section-title">Report</h5>
        
        <div class="mb-4">
            <h6 class="fw-bold text-dark mb-2">1. Overall Summary</h6>
            <div class="notes-box">
                <?php echo nl2br(htmlspecialchars($submission['overall_summary'] ?? 'No summary provided for this assessment.')); ?>
            </div>
        </div>

        <div class="mb-4">
            <h6 class="fw-bold text-dark mb-2">2. Recommendation</h6>
            <div class="notes-box">
                <?php echo nl2br(htmlspecialchars($submission['recommendations'] ?? 'No specific recommendation provided.')); ?>
            </div>
        </div>

        <div class="mb-4">
            <h6 class="fw-bold text-dark mb-2">3. Additional Comments</h6>
            <div class="notes-box">
                <?php echo nl2br(htmlspecialchars($submission['additional_comments'] ?? 'No additional comments provided.')); ?>
            </div>
        </div>

        <div class="signature-section">
            <div class="row">
                <div class="col-7">
                    <div class="signature-line"></div>
                    <p class="fw-bold mb-0"><?php echo htmlspecialchars($submission['officer_name'] ?? '_________________________'); ?></p>
                    <p class="text-muted small">Assessment Officer</p>
                    <?php if (!empty($submission['officer_signature'])): ?>
                        <p class="small italic text-muted mt-2"><?php echo nl2br(htmlspecialchars($submission['officer_signature'])); ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-5 text-end">
                    <p class="mb-1"><span class="fw-bold">Date of Report:</span> <?php echo !empty($submission['assessment_date']) ? date('F d, Y', strtotime($submission['assessment_date'])) : date('F d, Y'); ?></p>
                    <p class="small text-muted mt-4">This document is a formal assessment record generated by Center for Learning Disabilities.</p>
                </div>
            </div>
        </div>

        <div class="page-break"></div>
        <h5 class="section-title">Detailed Responses</h5>
        <?php
        $grouped_responses = [];
        foreach ($answers as $ans) {
            $sec = $ans['section'] ?: 'General';
            $sub = $ans['subsection'] ?: '';
            if (!isset($grouped_responses[$sec])) {
                $grouped_responses[$sec] = ['questions' => [], 'subsections' => []];
            }
            if ($sub) {
                if (!isset($grouped_responses[$sec]['subsections'][$sub])) {
                    $grouped_responses[$sec]['subsections'][$sub] = [];
                }
                $grouped_responses[$sec]['subsections'][$sub][] = $ans;
            } else {
                $grouped_responses[$sec]['questions'][] = $ans;
            }
        }
        ?>

        <?php 
        $q_count = 1;
        foreach ($grouped_responses as $section_name => $content): 
        ?>
            <div class="mb-5" style="page-break-inside: avoid;">
                <h6 class="fw-bold text-dark bg-light border-start border-4 border-primary p-2 rounded-1 mb-3">
                    <i class="fas fa-folder-open me-2 text-primary"></i> <?php echo htmlspecialchars($section_name); ?>
                </h6>
                
                <?php if (!empty($content['questions'])): ?>
                    <div class="ms-2 mb-3">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 75%; font-size: 12px; color: #000000;">Question</th>
                                <th class="text-center" style="font-size: 12px; color: #000000;">Response</th>
                                <th class="text-end" style="font-size: 12px; color: #000000;">Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($content['questions'] as $q): ?>
                                <tr style="border-bottom: 0.5px solid #ccc; color: #000000;">
                                    <td style="width: 75%; font-size: 12px;" class="py-2">
                                        <span class="me-1 fw-bold"><?php echo $q_count++; ?>.</span>
                                        <?php echo htmlspecialchars($q['question_text']); ?>
                                    </td>
                                    <td class="text-center py-2 fw-bold" style="font-size: 12px; color: <?php echo ($q['score'] >= 2) ? '#dc3545' : '#0d6efd'; ?>;">
                                        <?php echo htmlspecialchars($q['answer_text']); ?>
                                    </td>
                                    <td class="text-end py-2" style="font-size: 12px;">
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
                        <div class="ms-4 mb-4" style="page-break-inside: avoid;">
                            <div class="d-flex align-items-center mb-2">
                                <h6 class="fw-bold text-dark small mb-0 pe-3">
                                    <i class="fas fa-chevron-right text-primary me-2" style="font-size: 0.7rem;"></i> <?php echo htmlspecialchars($subsection_name); ?>
                                </h6>
                                <div class="flex-grow-1 border-bottom border-primary opacity-25"></div>
                            </div>
                            <table class="table table-sm table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 75%; font-size: 12px; color: #000000;">Question</th>
                                        <th class="text-center" style="font-size: 12px; color: #000000;">Response</th>
                                        <th class="text-end" style="font-size: 12px; color: #000000;">Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($sub_questions as $q): ?>
                                        <tr style="border-bottom: 0.5px solid #ccc; color: #000000;">
                                            <td style="width: 75%; font-size: 12px;" class="py-2 ps-3">
                                                <span class="me-1 fw-bold"><?php echo $q_count++; ?>.</span>
                                                <?php echo htmlspecialchars($q['question_text']); ?>
                                            </td>
                                            <td class="text-center py-2 fw-bold" style="font-size: 12px; color: <?php echo ($q['score'] >= 2) ? '#dc3545' : '#0d6efd'; ?>;">
                                                <?php echo htmlspecialchars($q['answer_text']); ?>
                                            </td>
                                            <td class="text-end py-2" style="font-size: 12px;">
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
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <div class="mt-5 text-center text-muted small border-top pt-3">
            <p>© <?php echo date('Y'); ?> Center for Learning Disabilities - All Right Reserved.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/@sgratzl/chartjs-chart-boxplot@4"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const analysis = <?php 
            $chartData = [];
            foreach($analysis as $k => $v) {
                $chartData[$k] = [
                    'score' => $v['score'],
                    'symptoms' => $v['symptoms']
                ];
            }
            echo json_encode($chartData); 
        ?>;
        const labels = Object.keys(analysis);
        const data = labels.map(label => analysis[label].score);
        const symptomData = labels.map(label => analysis[label].symptoms);
        
        const rawScores = <?php echo json_encode($raw_scores_by_domain); ?>;
        const boxplotLabels = Object.keys(rawScores);
        const boxplotDataValues = Object.values(rawScores);

        // Radar Chart
        const radarCtx = document.getElementById('domainRadarChart').getContext('2d');
        new Chart(radarCtx, {
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
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        beginAtZero: true,
                        ticks: { display: false }
                    }
                },
                plugins: { legend: { display: false } }
            }
        });

        // Bar Chart
        const barCtx = document.getElementById('scoresChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: 'rgba(13, 110, 253, 0.6)',
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } },
                plugins: { 
                    legend: { display: false }
                }
            }
        });

        const boxCtx = document.getElementById('boxplotChart').getContext('2d');
        new Chart(boxCtx, {
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
        
        // Auto-print after charts load (optional, but maybe better to let user click)
        // setTimeout(() => { window.print(); }, 1000);
    });
    </script>
</body>
</html>
