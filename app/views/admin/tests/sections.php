<?php require_once '../app/views/layout/header.php'; ?>

<main class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold text-dark">Manage Sections: <?php echo htmlspecialchars($test['title']); ?></h2>
                <p class="text-muted mb-0">Define the structure for this test.</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#addSectionModal">
                    <i class="fas fa-plus me-2"></i> Add Section
                </button>
                <a href="<?php echo ROOT; ?>/admin/tests" class="btn btn-outline-secondary px-4 rounded-pill fw-bold">
                    <i class="fas fa-arrow-left me-2"></i> Back to Tests
                </a>
            </div>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success rounded-3 mb-4">Structure updated successfully.</div>
        <?php endif; ?>
        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert alert-warning rounded-3 mb-4">Item deleted successfully.</div>
        <?php endif; ?>

        <div class="row">
            <?php if (empty($sections)): ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No sections defined yet. Start by adding one!</p>
                </div>
            <?php else: ?>
                <?php foreach ($sections as $sec): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold text-primary">
                                    <span class="badge bg-light text-primary border me-2"><?php echo $sec['sort_order']; ?></span>
                                    <?php echo htmlspecialchars($sec['name']); ?>
                                </h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light rounded-circle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                        <li><button class="dropdown-item text-primary add-sub-btn" data-section-id="<?php echo $sec['id']; ?>" data-section-name="<?php echo htmlspecialchars($sec['name']); ?>" data-bs-toggle="modal" data-bs-target="#addSubsectionModal"><i class="fas fa-plus me-2"></i> Add Sub-section</button></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="<?php echo ROOT; ?>/admin/section_delete/<?php echo $test['id']; ?>/<?php echo $sec['id']; ?>" onclick="return confirm('Deleting a section will remove all its sub-sections. Continue?')"><i class="fas fa-trash me-2"></i> Delete Section</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="text-uppercase small fw-bold text-muted mb-3">Sub-sections</h6>
                                <?php if (empty($sec['subsections'])): ?>
                                    <p class="small text-muted mb-0 italic text-center py-3">No sub-sections</p>
                                <?php else: ?>
                                    <div class="list-group list-group-flush rounded-3">
                                        <?php foreach ($sec['subsections'] as $sub): ?>
                                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                                <span>
                                                    <span class="text-muted me-2"><?php echo $sub['sort_order']; ?>.</span>
                                                    <?php echo htmlspecialchars($sub['name']); ?>
                                                </span>
                                                <a href="<?php echo ROOT; ?>/admin/subsection_delete/<?php echo $test['id']; ?>/<?php echo $sub['id']; ?>" class="text-danger small" onclick="return confirm('Remove sub-section?')"><i class="fas fa-times"></i></a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- Add Section Modal -->
<div class="modal fade" id="addSectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Add New Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <input type="hidden" name="add_section" value="1">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Section Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Part A: Inattentive Symptoms" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Add Section</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Subsection Modal -->
<div class="modal fade" id="addSubsectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Add Sub-section to <span id="targetSectionName" class="text-primary"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <input type="hidden" name="add_subsection" value="1">
                    <input type="hidden" name="section_id" id="targetSectionId">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Sub-section Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Fine Motor Skills" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Add Sub-section</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const subButtons = document.querySelectorAll('.add-sub-btn');
    subButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('targetSectionId').value = this.dataset.sectionId;
            document.getElementById('targetSectionName').innerText = this.dataset.sectionName;
        });
    });

    <?php if (isset($_GET['add'])): ?>
    const addSectionModal = new bootstrap.Modal(document.getElementById('addSectionModal'));
    addSectionModal.show();
    <?php endif; ?>
});
</script>

<?php require_once '../app/views/layout/footer.php'; ?>
