<?php require_once '../app/views/layout/header.php'; ?>

<main class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark">Submissions: <?php echo htmlspecialchars($test['title']); ?></h2>
                <p class="text-muted mb-0">View user submissions for this test.</p>
            </div>
            <a href="<?php echo ROOT; ?>/admin/tests" class="btn btn-outline-secondary px-4 rounded-pill fw-bold">
                <i class="fas fa-arrow-left me-2"></i> Back to Tests
            </a>
        </div>

        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4 border-0 shadow-sm px-4 py-3" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fa-lg me-3 text-success"></i>
                    <div>
                        <strong class="text-dark">Deleted!</strong> Submission has been permanently removed.
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Search Bar -->
        <div class="row mb-4">
            <div class="col-md-6 col-lg-5">
                <form action="<?php echo ROOT; ?>/admin/test_submissions/<?php echo $test['id']; ?>" method="GET">
                    <div class="input-group shadow-sm rounded-4 overflow-hidden bg-white border">
                        <span class="input-group-text border-0 bg-transparent text-muted px-3">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="q" class="form-control border-0 bg-transparent py-2 shadow-none" placeholder="Search by name, email, or phone..." value="<?php echo htmlspecialchars($search ?? ''); ?>">
                        <?php if (!empty($search)): ?>
                            <a href="<?php echo ROOT; ?>/admin/test_submissions/<?php echo $test['id']; ?>" class="btn border-0 bg-transparent text-muted py-2 d-flex align-items-center" title="Clear Search">
                                <i class="fas fa-times"></i>
                            </a>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-4 py-3 text-secondary small text-uppercase fw-bold">User</th>
                                <th class="border-0 px-4 py-3 text-secondary small text-uppercase fw-bold">Contact</th>
                                <th class="border-0 px-4 py-3 text-secondary small text-uppercase fw-bold">Date</th>
                                <th class="border-0 px-4 py-3 text-secondary small text-uppercase fw-bold">Status</th>
                                <th class="border-0 px-4 py-3 text-secondary small text-uppercase fw-bold text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($submissions)): ?>
                                <tr>
                                    <td colspan="5" class="px-4 py-5 text-center text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                                        <p><?php echo !empty($search) ? 'No submissions match your search.' : 'No submissions yet.'; ?></p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($submissions as $sub): ?>
                                    <tr>
                                        <td class="px-4 py-3 fw-bold"><?php echo htmlspecialchars($sub['user_name']); ?></td>
                                        <td class="px-4 py-3 small text-muted">
                                            <?php echo htmlspecialchars($sub['user_email']); ?><br>
                                            <?php echo htmlspecialchars($sub['user_phone']); ?>
                                        </td>
                                        <td class="px-4 py-3 small text-muted"><?php echo date('M d, Y H:i', strtotime($sub['created_at'])); ?></td>
                                        <td class="px-4 py-3">
                                            <?php if ($sub['status'] == 'pending'): ?>
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            <?php elseif ($sub['status'] == 'paid'): ?>
                                                <span class="badge bg-success">Paid</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><?php echo ucfirst($sub['status']); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-3 text-end">
                                            <?php if ($sub['status'] == 'pending'): ?>
                                                <button onclick="copyToClipboard('<?php echo ROOT; ?>/tests/complete/<?php echo $sub['id']; ?>')" class="btn btn-sm btn-outline-warning me-1" title="Copy Payment Link">
                                                    <i class="fas fa-link"></i> Link
                                                </button>
                                            <?php endif; ?>
                                            <a href="<?php echo ROOT; ?>/admin/submission_view/<?php echo $sub['id']; ?>" class="btn btn-sm btn-outline-primary" title="View Details">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="<?php echo ROOT; ?>/admin/submission_print/<?php echo $sub['id']; ?>" target="_blank" class="btn btn-sm btn-outline-secondary" title="Print Report">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <a href="<?php echo ROOT; ?>/admin/submission_delete/<?php echo $sub['id']; ?>" onclick="return confirm('Are you sure you want to permanently delete this submission?')" class="btn btn-sm btn-outline-danger ms-1" title="Delete Submission">
                                                <i class="fas fa-trash"></i> Delete
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

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Payment link copied to clipboard!');
    });
}
</script>

<?php require_once '../app/views/layout/footer.php'; ?>
