<?php require_once '../app/views/layout/header.php'; ?>

<main class="py-5" style="min-height: 90vh; background-color: #646df7ff;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border border-light-subtle">
                
                <!-- Assessment Header -->
                <div class="text-start mb-4">
                    <h4 class="assessment-title"><?php echo htmlspecialchars($test['title']); ?></h4>
                    <p id="assessmentSub" class="assessment-subtitle">Assessment 1 of <?php echo count($questions) + 3; ?></p>
                    <!-- <p id="assessmentDesc" class="assessment-description"><?php// echo htmlspecialchars($test['description']); ?></p> -->
                </div>

                <!-- Progress Section -->
                <div class="mb-5">
                    <div class="progress-container">
                        <div id="progressBar" class="progress-bar-teal"></div>
                    </div>
                </div>

                <form id="assessmentForm" action="" method="POST">
                    
                    <!-- Step 0: Form Instructions & Things to Know -->
                    <div class="step active" data-step="0">
                        <div class="instruction-card p-4 rounded-4 bg-white mb-4 shadow-sm">
                            <h2 class="h4 fw-bold mb-4 text-dark d-flex align-items-center gap-2">
                                <i class="fas fa-info-circle text-primary"></i>
                                Form Instructions & Things to Know
                            </h2>
                            
                            <div class="mb-4">
                                <h6 class="fw-bold text-dark small text-uppercase mb-3">How to fill this form:</h6>
                                <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                                    <li class="d-flex align-items-center gap-2 text-muted small">
                                        <i class="fas fa-check text-success"></i>
                                        Read each question carefully before selecting an answer.
                                    </li>
                                    <li class="d-flex align-items-center gap-2 text-muted small">
                                        <i class="fas fa-check text-success"></i>
                                        Select the most accurate option based on your observations.
                                    </li>
                                    <li class="d-flex align-items-center gap-2 text-muted small">
                                        <i class="fas fa-check text-success"></i>
                                        Do not skip questions; every response helps in the assessment.
                                    </li>
                                </ul>
                            </div>

                            <hr class="my-4 opacity-50">

                            <h6 class="fw-bold text-dark small text-uppercase mb-3">Things to know:</h6>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="icon-circle bg-primary-soft text-primary small">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold small">10-15 Mins</h6>
                                            <p class="text-muted mb-0" style="font-size: 0.75rem;">Estimated completion time.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="icon-circle bg-success-soft text-success small">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold small">Secure</h6>
                                            <p class="text-muted mb-0" style="font-size: 0.75rem;">Your data is fully encrypted.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert bg-warning-soft border-0 rounded-4 p-3 d-flex align-items-start gap-3">
                            <div class="text-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="small text-dark-emphasis">
                                <strong>Note:</strong> This is a screening and assessment tool, not clinical (medical).
                            </div>
                        </div>
                    </div>

                    <!-- Step 1: Filing Person Information -->
                    <div class="step" data-step="1">
                        <h2 class="question-text">First, please provide your contact information.</h2>
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted text-uppercase">Your Full Name</label>
                                <input type="text" name="user_name" id="user_name" class="form-control form-control-lg border-2 rounded-3" placeholder="Enter your full name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Email Address</label>
                                <input type="email" name="user_email" id="user_email" class="form-control form-control-lg border-2 rounded-3" placeholder="name@example.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Phone Number</label>
                                <input type="tel" name="user_phone" id="user_phone" class="form-control form-control-lg border-2 rounded-3" placeholder="Phone number" required>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Individual Being Assessed -->
                    <div class="step" data-step="2">
                        <h2 class="question-text">Information about the individual being assessed.</h2>
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted text-uppercase">Who are you filing for?</label>
                                <select name="filing_for" id="filing_for" class="form-select form-select-lg border-2 rounded-3" onchange="toggleSelfAssessment()" required>
                                    <option value="" selected disabled>Choose relationship...</option>
                                    <option value="Self">Self</option>
                                    <option value="Child">Child</option>
                                    <option value="Partner">Partner</option>
                                    <option value="Family Member">Family Member</option>
                                    <option value="Friend">Friend</option>
                                    <option value="Caretaker">Caretaker</option>
                                    <option value="Guardian">Guardian</option>
                                    <option value="Teacher/Tutor">Teacher/Tutor</option>
                                </select>
                            </div>

                            <div class="col-12" id="assessed_name_container" style="display: none;">
                                <label class="form-label small fw-bold text-muted text-uppercase">Name of Individual Being Assessed</label>
                                <input type="text" name="assessed_name" id="assessed_name" class="form-control form-control-lg border-2 rounded-3" placeholder="Individual's name">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Date of Birth</label>
                                <input type="date" name="dob" id="dob" class="form-control form-control-lg border-2 rounded-3" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Age</label>
                                <input type="number" name="age" id="age" class="form-control form-control-lg border-2 rounded-3" placeholder="Age" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Gender <span class="text-danger">*</span></label>
                                <select name="gender" id="gender" class="form-select form-select-lg border-2 rounded-3" required>
                                    <option value="" selected disabled>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <div class="col-md-6" id="school_grade_container" style="display: none;">
                                <label class="form-label small fw-bold text-muted text-uppercase">School Grade (Optional)</label>
                                <input type="text" name="school_grade" id="school_grade" class="form-control form-control-lg border-2 rounded-3" placeholder="e.g. Grade 5">
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted text-uppercase">Assessment Reasons / Reason for Assessment</label>
                                <textarea name="assessment_reason" id="assessment_reason" class="form-control form-control-lg border-2 rounded-3" rows="3" placeholder="Please provide reasons for this assessment" required></textarea>
                            </div>
                        </div>
                    </div>

                    <script>
                        function toggleSelfAssessment() {
                            const filingFor = document.getElementById('filing_for').value;
                            const assessedNameContainer = document.getElementById('assessed_name_container');
                            const schoolGradeContainer = document.getElementById('school_grade_container');
                            const assessedNameInput = document.getElementById('assessed_name');

                            // Handle name of the person being assessed
                            if (filingFor === 'Self' || filingFor === '') {
                                assessedNameContainer.style.display = 'none';
                                assessedNameInput.removeAttribute('required');
                            } else {
                                assessedNameContainer.style.display = 'block';
                                assessedNameInput.setAttribute('required', 'required');
                            }

                            // Show School Grade only for specific relationships
                            const showGradeRoles = ['Child', 'Caretaker', 'Guardian', 'Teacher/Tutor'];
                            if (showGradeRoles.includes(filingFor)) {
                                schoolGradeContainer.style.display = 'block';
                            } else {
                                schoolGradeContainer.style.display = 'none';
                            }
                        }
                    </script>

                    <!-- Question Steps -->
                    <?php if (!empty($questions)): ?>
                        <?php foreach ($questions as $index => $q): ?>
                            <div class="step" data-step="<?php echo $index + 3; ?>" data-section="<?php echo htmlspecialchars($q['section']); ?>">
                                <!-- Section info hidden from client -->

                                <div class="question-text">
                                    <?php echo ($index + 1) . '. ' . htmlspecialchars($q['question_text']); ?>
                                </div>

                                <div class="options-container">
                                    <?php if ($q['type'] == 'text'): ?>
                                        <textarea name="q_<?php echo $q['id']; ?>" class="form-control form-control-lg border-2 rounded-4" rows="4" placeholder="Type your answer here..." required></textarea>
                                    <?php elseif ($q['type'] == 'radio'): ?>
                                        <?php 
                                        $options = json_decode($q['options'], true) ?? [];
                                        foreach ($options as $k => $opt): 
                                            $optVal = is_array($opt) ? $opt['text'] : $opt;
                                        ?>
                                            <div class="mb-3">
                                                <input class="d-none" type="radio" name="q_<?php echo $q['id']; ?>" value="<?php echo htmlspecialchars($optVal); ?>" id="q_<?php echo $q['id']; ?>_<?php echo $k; ?>" required>
                                                <label class="option-pill" for="q_<?php echo $q['id']; ?>_<?php echo $k; ?>">
                                                    <?php echo htmlspecialchars($optVal); ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php elseif ($q['type'] == 'checkbox'): ?>
                                        <?php 
                                        $options = json_decode($q['options'], true) ?? [];
                                        foreach ($options as $k => $opt): 
                                            $optVal = is_array($opt) ? $opt['text'] : $opt;
                                        ?>
                                            <div class="mb-3">
                                                <input class="d-none" type="checkbox" name="q_<?php echo $q['id']; ?>[]" value="<?php echo htmlspecialchars($optVal); ?>" id="q_<?php echo $q['id']; ?>_<?php echo $k; ?>">
                                                <label class="option-pill" for="q_<?php echo $q['id']; ?>_<?php echo $k; ?>">
                                                    <?php echo htmlspecialchars($optVal); ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- Navigation -->
                    <div class="nav-buttons">
                        <button type="button" id="prevBtn" class="nav-link-btn" onclick="nextPrev(-1)" style="visibility: hidden;">Previous</button>
                        <button type="button" id="nextBtn" class="nav-link-btn" onclick="nextPrev(1)">Next</button>
                    </div>

                </form>
            </div>
        </div>
        </div>
    </div>
</main>

<style>
    body {
        background-color: #fff !important;
        font-family: 'Inter', sans-serif;
    }
    .assessment-title {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        color: #000;
        letter-spacing: -0.5px;
    }
    .assessment-subtitle {
        font-size: 1rem;
        color: #3b82f6;
        font-weight: 200;
        margin-bottom: 0.5rem;
    }
    .assessment-description {
        font-size: 1.15rem;
        line-height: 1.5;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
        max-width: 90%;
    }
    .progress-container {
        height: 6px;
        background-color: #f1f3f5;
        border-radius: 10px;
        margin-bottom: 0.8rem;
        overflow: hidden;
    }
    .progress-bar-teal {
        height: 100%;
        background-color: #26c19b;
        width: 0%;
        border-radius: 10px;
        transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .question-info {
        color: #94a3b8;
        font-size: 1.1rem;
        font-weight: 500;
        margin-bottom: 2rem;
    }
    .question-text {
        font-size: 1.4rem;
        font-weight: 500;
        line-height: 1.5;
        margin-bottom: 2.5rem;
        color: #1e293b;
    }
    .option-pill {
        display: block;
        width: 100%;
        padding: 14px 24px;
        background-color: #fff;
        border: 2px solid #3b82f6;
        border-radius: 100px;
        color: #3b82f6;
        font-size: 1.2rem;
        font-weight: 600;
        text-align: center;
        transition: all 0.2s ease;
        cursor: pointer;
        user-select: none;
    }
    .option-pill:hover {
        background-color: #eff6ff;
    }
    input:checked + .option-pill {
        background-color: #3b82f6;
        color: #fff;
    }
    .step {
        display: none;
        animation: fadeIn 0.4s ease;
    }
    .step.active {
        display: block;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .nav-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 4rem;
        padding-top: 2rem;
        border-top: 1px solid #f1f3f5;
    }
    .nav-link-btn {
        color: #3b82f6;
        font-size: 1.3rem;
        font-weight: 500;
        background: none;
        border: none;
        padding: 10px 0;
        cursor: pointer;
        transition: opacity 0.2s;
    }
    .nav-link-btn:hover {
        opacity: 0.8;
    }
    .form-control-lg {
        padding: 12px 20px;
        font-size: 1.1rem;
    }
    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.1);
    }
    .bg-primary-soft { background-color: #eff6ff; }
    .bg-success-soft { background-color: #f0fdf4; }
    .bg-info-soft { background-color: #f0f9ff; }
    .bg-warning-soft { background-color: #fffbeb; }
    .icon-circle {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        flex-shrink: 0;
    }
    .instruction-card {
        border: 1px solid #e2e8f0;
    }
</style>

<script>
    var currentTab = 0;
    showTab(currentTab);

    function showTab(n) {
        var x = document.getElementsByClassName("step");
        x[n].classList.add("active");
        
        // Show/Hide buttons
        if (n == 0) {
            document.getElementById("prevBtn").style.visibility = "hidden";
        } else {
            document.getElementById("prevBtn").style.visibility = "visible";
        }
        
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Submit Results";
        } else {
            document.getElementById("nextBtn").innerHTML = "Next";
        }
        
        updateProgress(n);
        window.scrollTo(0, 0);
    }

    function nextPrev(n) {
        var x = document.getElementsByClassName("step");
        
        // Validate before moving next
        if (n == 1 && !validateForm()) return false;
        
        x[currentTab].classList.remove("active");
        currentTab = currentTab + n;
        
        if (currentTab >= x.length) {
            document.getElementById("assessmentForm").submit();
            return false;
        }
        
        showTab(currentTab);
    }

    function validateForm() {
        var x, y, i, valid = true;
        x = document.getElementsByClassName("step");
        y = x[currentTab].querySelectorAll("input, textarea");
        
        // Custom validation for current step
        for (i = 0; i < y.length; i++) {
            if (y[i].hasAttribute("required")) {
                if (y[i].type === "radio" || y[i].type === "checkbox") {
                    // Check if at least one in the group is checked
                    let name = y[i].getAttribute("name");
                    if (!x[currentTab].querySelector('input[name="' + name + '"]:checked')) {
                        valid = false;
                    }
                } else if (y[i].value == "") {
                    y[i].classList.add("is-invalid");
                    valid = false;
                } else {
                    y[i].classList.remove("is-invalid");
                }
            }
        }
        
        return valid;
    }

    function updateProgress(n) {
        var x = document.getElementsByClassName("step");
        var prg = ((n) / (x.length - 1)) * 100;
        document.getElementById("progressBar").style.width = prg + "%";
        
        var sub = document.getElementById("assessmentSub");
        var desc = document.getElementById("assessmentDesc");
        
        sub.style.visibility = "visible";
        
        // Hide description after the first step to save space
        if (n > 0) {
            desc.style.display = "none";
        } else {
            desc.style.display = "block";
        }
        
        // Show current step out of total steps
        sub.innerHTML = "Assessment " + (n + 1) + " of " + x.length;
    }
</script>

<?php require_once '../app/views/layout/footer.php'; ?>

