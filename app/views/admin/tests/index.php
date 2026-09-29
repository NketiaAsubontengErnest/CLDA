<?php require_once '../app/views/layout/header.php'; ?>

<main class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold text-dark">Manage Tests</h2>
                <p class="text-muted mb-0">Create and manage online questionnaires.</p>
            </div>
            <div class="d-flex gap-2">
                 <button class="btn btn-primary rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#addTestModal">
                    <i class="fas fa-plus me-2"></i> Create Test
                </button>
                <a href="<?php echo ROOT; ?>/admin" class="btn btn-outline-secondary px-4 rounded-pill fw-bold">
                    <i class="fas fa-arrow-left me-2"></i> Dashboard
                </a>
            </div>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success rounded-3 mb-4">Action completed successfully.</div>
        <?php endif; ?>
        <?php if (isset($_GET['updated'])): ?>
            <div class="alert alert-info rounded-3 mb-4">Test updated successfully.</div>
        <?php endif; ?>
        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert alert-warning rounded-3 mb-4">Test deleted successfully.</div>
        <?php endif; ?>

        <form action="<?php echo ROOT; ?>/admin/tests" method="GET" class="mb-4">
            <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white">
                <span class="input-group-text border-0 bg-transparent ps-4"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="q" class="form-control border-0 bg-transparent py-2 shadow-none" placeholder="Search tests by title, description or tag..." value="<?php echo htmlspecialchars($search ?? ''); ?>">
                <?php if (!empty($search)): ?>
                    <a href="<?php echo ROOT; ?>/admin/tests" class="btn border-0 bg-transparent text-muted py-2 d-flex align-items-center" title="Clear Search"><i class="fas fa-times"></i></a>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary px-4 fw-bold">Search</button>
            </div>
        </form>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-4 py-3 text-secondary small text-uppercase fw-bold">Title</th>
                                <th class="border-0 px-4 py-3 text-secondary small text-uppercase fw-bold">Price</th>
                                <th class="border-0 px-4 py-3 text-secondary small text-uppercase fw-bold">Submissions</th>
                                <th class="border-0 px-4 py-3 text-secondary small text-uppercase fw-bold">Status</th>
                                <th class="border-0 px-4 py-3 text-secondary small text-uppercase fw-bold">Created</th>
                                <th class="border-0 px-4 py-3 text-secondary small text-uppercase fw-bold text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($tests)): ?>
                                <tr>
                                    <td colspan="6" class="px-4 py-5 text-center text-muted">
                                        <i class="fas fa-clipboard-list fa-3x mb-3 opacity-25"></i>
                                        <p><?php echo !empty($search) ? 'No tests match your search.' : 'No tests found. Create one to get started.'; ?></p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($tests as $test): ?>
                                    <tr>
                                        <td class="px-4 py-3">
                                            <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($test['title']); ?></h6>
                                            <small class="text-muted d-block"><?php echo htmlspecialchars(substr($test['description'] ?? '', 0, 50)) . '...'; ?></small>
                                            <?php if (!empty($test['tags'])): ?>
                                                <div class="mt-1">
                                                    <?php foreach (explode(',', $test['tags']) as $tag): ?>
                                                        <span class="badge bg-light text-dark border small fw-normal"><?php echo htmlspecialchars(trim($tag)); ?></span>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-3">GH₵ <?php echo number_format($test['price'], 2); ?></td>
                                        <td class="px-4 py-3">
                                            <a href="<?php echo ROOT; ?>/admin/test_submissions/<?php echo $test['id']; ?>" class="badge bg-info text-dark text-decoration-none fw-bold px-3 py-2 rounded-pill" title="View Submissions">
                                                <i class="fas fa-file-alt me-1"></i> <?php echo $test['submissions_count']; ?>
                                            </a>
                                        </td>
                                        <td class="px-4 py-3">
                                            <?php if ($test['is_active']): ?>
                                                <a href="<?php echo ROOT; ?>/admin/tests_toggle_status/<?php echo $test['id']; ?>" class="badge bg-success text-decoration-none" title="Click to Deactivate">Active</a>
                                            <?php else: ?>
                                                <a href="<?php echo ROOT; ?>/admin/tests_toggle_status/<?php echo $test['id']; ?>" class="badge bg-secondary text-decoration-none" title="Click to Activate">Inactive</a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-3 small text-muted"><?php echo date('M d, Y', strtotime($test['created_at'])); ?></td>
                                        <td class="px-4 py-3 text-end">
                                            <a href="<?php echo ROOT; ?>/admin/test_sections/<?php echo $test['id']; ?>?add=1" class="btn btn-sm btn-outline-primary me-1" title="Add Section">
                                                <i class="fas fa-plus-circle"></i> Add Section
                                            </a>
                                            <a href="<?php echo ROOT; ?>/admin/test_sections/<?php echo $test['id']; ?>" class="btn btn-sm btn-outline-dark me-1" title="Manage Structure">
                                                <i class="fas fa-layer-group"></i> Sections
                                            </a>
                                            <a href="<?php echo ROOT; ?>/admin/test_questions/<?php echo $test['id']; ?>" class="btn btn-sm btn-outline-info me-1" title="Manage Questions">
                                                <i class="fas fa-list-ol"></i> Questions
                                            </a>
                                            <button class="btn btn-sm btn-outline-secondary me-1" onclick="copyToClipboard('<?php echo ROOT; ?>/tests/take_walkin/<?php echo $test['id']; ?>', 'Walk-in Link')" title="Copy Walk-in Link">
                                                <i class="fas fa-link"></i> Walk-in Link
                                            </button>
                                            <a href="<?php echo ROOT; ?>/admin/test_submissions/<?php echo $test['id']; ?>" class="btn btn-sm btn-outline-success me-1" title="View Submissions">
                                                <i class="fas fa-user-check"></i> Submissions
                                            </a>
                                            <button class="btn btn-sm btn-outline-primary me-1 edit-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editTestModal" 
                                                data-id="<?php echo $test['id']; ?>"
                                                data-title="<?php echo htmlspecialchars($test['title']); ?>"
                                                data-description="<?php echo htmlspecialchars($test['description']); ?>"
                                                data-price="<?php echo $test['price']; ?>"
                                                data-tags="<?php echo htmlspecialchars($test['tags'] ?? ''); ?>"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="<?php echo ROOT; ?>/admin/tests_delete/<?php echo $test['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure? This will delete all questions and submissions for this test.')" title="Delete">
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
            <?php if (($totalPages ?? 1) > 1): ?>
                <?php
                $qs = !empty($search) ? '&q=' . urlencode($search) : '';
                $from = max(1, $page - 2);
                $to = min($totalPages, $page + 2);
                ?>
                <div class="card-footer bg-white border-0 rounded-bottom-4 d-flex flex-wrap justify-content-between align-items-center gap-2 px-4 py-3">
                    <small class="text-muted">Page <?php echo $page; ?> of <?php echo $totalPages; ?> (<?php echo $total; ?> tests)</small>
                    <nav aria-label="Tests pagination">
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>"><a class="page-link" href="?page=<?php echo $page - 1 . $qs; ?>">&laquo;</a></li>
                            <?php for ($i = $from; $i <= $to; $i++): ?>
                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $i . $qs; ?>"><?php echo $i; ?></a></li>
                            <?php endfor; ?>
                            <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>"><a class="page-link" href="?page=<?php echo $page + 1 . $qs; ?>">&raquo;</a></li>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- Add Test Modal -->
<div class="modal fade" id="addTestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Create New Test</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <input type="hidden" name="create_test" value="1">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Price (GH₵)</label>
                        <input type="number" name="price" class="form-control" step="0.01" value="0.00">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tags (comma separated)</label>
                        <input type="text" name="tags" class="form-control" placeholder="e.g. Literacy, Math, Diagnostic">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Create Test</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Test Modal -->
<div class="modal fade" id="editTestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Test</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <input type="hidden" name="edit_test" value="1">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Title</label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Price (GH₵)</label>
                        <input type="number" name="price" id="edit_price" class="form-control" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tags (comma separated)</label>
                        <input type="text" name="tags" id="edit_tags" class="form-control" placeholder="e.g. Literacy, Math, Diagnostic">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-btn');
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('edit_id').value = this.dataset.id;
                document.getElementById('edit_title').value = this.dataset.title;
                document.getElementById('edit_description').value = this.dataset.description;
                document.getElementById('edit_price').value = this.dataset.price;
                document.getElementById('edit_tags').value = this.dataset.tags;
            });
        });
    });

    function copyToClipboard(text, label) {
        navigator.clipboard.writeText(text).then(() => {
            alert(label + ' copied to clipboard!');
        });
    }
</script>

<?php require_once '../app/views/layout/footer.php'; ?>
