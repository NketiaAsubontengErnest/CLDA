<?php require_once '../app/views/layout/header.php'; ?>

<main class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold text-dark">Questions: <?php echo htmlspecialchars($test['title']); ?></h2>
                <p class="text-muted mb-0">Manage questions for this test.</p>
            </div>
            <div class="d-flex gap-2">
                 <button class="btn btn-primary rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                    <i class="fas fa-plus me-2"></i> Add Question
                </button>
                 <a href="<?php echo ROOT; ?>/admin/test_sections/<?php echo $test['id']; ?>" class="btn btn-outline-dark px-4 rounded-pill fw-bold">
                    <i class="fas fa-layer-group me-2"></i> Manage Sections
                </a>
                <a href="<?php echo ROOT; ?>/admin/tests" class="btn btn-outline-secondary px-4 rounded-pill fw-bold">
                    <i class="fas fa-arrow-left me-2"></i> Back to Tests
                </a>
            </div>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success rounded-3 mb-4">Question added successfully.</div>
        <?php endif; ?>
        <?php if (isset($_GET['updated'])): ?>
            <div class="alert alert-info rounded-3 mb-4">Question updated successfully.</div>
        <?php endif; ?>
        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert alert-warning rounded-3 mb-4">Question deleted successfully.</div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-4 py-3 text-secondary small text-uppercase fw-bold" width="5%">Order</th>
                                <th class="border-0 px-4 py-3 text-secondary small text-uppercase fw-bold" width="40%">Question</th>
                                <th class="border-0 px-4 py-3 text-secondary small text-uppercase fw-bold" width="10%">Type</th>
                                <th class="border-0 px-4 py-3 text-secondary small text-uppercase fw-bold" width="15%">Section</th>
                                <th class="border-0 px-4 py-3 text-secondary small text-uppercase fw-bold" width="15%">Sub-section</th>
                                <th class="border-0 px-4 py-3 text-secondary small text-uppercase fw-bold" width="20%">Options</th>
                                <th class="border-0 px-4 py-3 text-secondary small text-uppercase fw-bold text-end" width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($questions)): ?>
                                <tr>
                                    <td colspan="5" class="px-4 py-5 text-center text-muted">
                                        <i class="fas fa-question-circle fa-3x mb-3 opacity-25"></i>
                                        <p>No questions added yet.</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($questions as $q): ?>
                                    <tr>
                                        <td class="px-4 py-3 text-center fw-bold text-muted"><?php echo $q['sort_order']; ?></td>
                                        <td class="px-4 py-3"><?php echo htmlspecialchars($q['question_text']); ?></td>
                                        <td class="px-4 py-3"><span class="badge bg-light text-dark border"><?php echo ucfirst($q['type']); ?></span></td>
                                        <td class="px-4 py-3 small text-muted"><?php echo htmlspecialchars($q['section'] ?? '-'); ?></td>
                                        <td class="px-4 py-3 small text-muted"><?php echo htmlspecialchars($q['subsection'] ?? '-'); ?></td>
                                        <td class="px-4 py-3 small text-muted">
                                            <?php 
                                            if (!empty($q['options'])) {
                                                $opts = json_decode($q['options'], true);
                                                if (is_array($opts)) {
                                                    $displayOpts = [];
                                                    foreach ($opts as $opt) {
                                                        if (is_array($opt)) {
                                                            $displayOpts[] = htmlspecialchars($opt['text']) . " (" . $opt['score'] . ")";
                                                        } else {
                                                            $displayOpts[] = htmlspecialchars($opt);
                                                        }
                                                    }
                                                    echo implode(', ', $displayOpts);
                                                } else {
                                                    echo '-';
                                                }
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </td>
                                        <td class="px-4 py-3 text-end">
                                            <button class="btn btn-sm btn-outline-primary me-1 edit-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editQuestionModal" 
                                                data-id="<?php echo $q['id']; ?>"
                                                data-text="<?php echo htmlspecialchars($q['question_text'], ENT_QUOTES); ?>"
                                                data-type="<?php echo $q['type']; ?>"
                                                data-section-id="<?php echo htmlspecialchars($q['section_id'] ?? '', ENT_QUOTES); ?>"
                                                data-subsection-id="<?php echo htmlspecialchars($q['subsection_id'] ?? '', ENT_QUOTES); ?>"
                                                data-options='<?php echo htmlspecialchars($q['options'] ?? "[]", ENT_QUOTES); ?>'
                                                data-order="<?php echo $q['sort_order']; ?>"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="<?php echo ROOT; ?>/admin/question_delete/<?php echo $test['id']; ?>/<?php echo $q['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Add Question Modal -->
<div class="modal fade" id="addQuestionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Add Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <input type="hidden" name="add_question" value="1">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Question Text</label>
                        <textarea name="question_text" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Type</label>
                            <select name="type" class="form-select" id="add_type" onchange="toggleOptions('add')">
                                <option value="text">Text Input</option>
                                <option value="radio">Multiple Choice (Radio)</option>
                                <option value="checkbox">Checkbox (Multiple Select)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Section</label>
                            <select name="section_id" id="add_section_id" class="form-select" onchange="updateSubsections('add')">
                                <option value="">General / No Section</option>
                                <?php foreach ($sections as $sec): ?>
                                    <option value="<?php echo $sec['id']; ?>"><?php echo htmlspecialchars($sec['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Sub-section</label>
                            <select name="subsection_id" id="add_subsection_id" class="form-select">
                                <option value="">Select a section first</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="0">
                        </div>
                    <div class="mb-3 d-none" id="add_options_div">
                        <label class="form-label small fw-bold">Options</label>
                        <p class="text-muted small mb-1">Format: <code>Option Text: Score</code> (comma separated). Example: <code>Never:0, Sometimes:1, Often:2</code></p>
                        <input type="text" name="options" class="form-control" placeholder="Never:0, Sometimes:1, Often:2">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Add Question</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Question Modal -->
<div class="modal fade" id="editQuestionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <input type="hidden" name="edit_question" value="1">
                    <input type="hidden" name="question_id" id="edit_id">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Question Text</label>
                        <textarea name="question_text" id="edit_text" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Type</label>
                            <select name="type" id="edit_type" class="form-select" onchange="toggleOptions('edit')">
                                <option value="text">Text Input</option>
                                <option value="radio">Multiple Choice (Radio)</option>
                                <option value="checkbox">Checkbox (Multiple Select)</option>
                            </select>
                        </div>
                         <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Section</label>
                            <select name="section_id" id="edit_section_id" class="form-select" onchange="updateSubsections('edit')">
                                <option value="">General / No Section</option>
                                <?php foreach ($sections as $sec): ?>
                                    <option value="<?php echo $sec['id']; ?>"><?php echo htmlspecialchars($sec['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Sub-section</label>
                            <select name="subsection_id" id="edit_subsection_id" class="form-select">
                                <option value="">Select a section first</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" id="edit_order" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3 d-none" id="edit_options_div">
                        <label class="form-label small fw-bold">Options</label>
                        <p class="text-muted small mb-1">Format: <code>Option Text: Score</code> (comma separated). Example: <code>Never:0, Sometimes:1, Often:2</code></p>
                        <input type="text" name="options" id="edit_options" class="form-control" placeholder="Never:0, Sometimes:1, Often:2">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const subsectionsMap = <?php echo json_encode($subsections_map ?? [], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

    function updateSubsections(mode, selectedSubId = '') {
        const sectionId = document.getElementById(mode + '_section_id').value;
        const subSelect = document.getElementById(mode + '_subsection_id');
        
        if (!subSelect) return;
        
        subSelect.innerHTML = '<option value="">No Sub-section</option>';
        
        if (sectionId && subsectionsMap && subsectionsMap[sectionId]) {
            subsectionsMap[sectionId].forEach(sub => {
                const option = document.createElement('option');
                option.value = sub.id;
                option.text = sub.name;
                if (sub.id == selectedSubId) option.selected = true;
                subSelect.appendChild(option);
            });
        } else if (!sectionId) {
            subSelect.innerHTML = '<option value="">Select a section first</option>';
        }
    }

    function toggleOptions(mode) {
        const type = document.getElementById(mode + '_type').value;
        const optionsDiv = document.getElementById(mode + '_options_div');
        if (type === 'text') {
            optionsDiv.classList.add('d-none');
        } else {
            optionsDiv.classList.remove('d-none');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-btn');
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('edit_id').value = this.dataset.id;
                document.getElementById('edit_text').value = this.dataset.text;
                document.getElementById('edit_type').value = this.dataset.type;
                document.getElementById('edit_section_id').value = this.dataset.sectionId || '';
                
                // Update subsections and set value
                updateSubsections('edit', this.dataset.subsectionId || '');
                
                // Parse options back to string for display
                const options = JSON.parse(this.dataset.options);
                let optionsStr = '';
                if (Array.isArray(options)) {
                   optionsStr = options.map(opt => {
                       if (typeof opt === 'object') {
                           return opt.text + ':' + opt.score;
                       }
                       return opt;
                   }).join(', ');
                }
                
                document.getElementById('edit_options').value = optionsStr;
                document.getElementById('edit_order').value = this.dataset.order;
                
                toggleOptions('edit');
            });
        });
    });
</script>

<?php require_once '../app/views/layout/footer.php'; ?>
