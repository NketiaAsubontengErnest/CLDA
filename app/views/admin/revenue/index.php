<?php require_once '../app/views/layout/header.php'; ?>
<?php
$qs = (!empty($search) ? '&q=' . urlencode($search) : '') . (!empty($source) ? '&source=' . urlencode($source) : '');
$badge = ['sent' => 'bg-success', 'pending' => 'bg-secondary', 'failed' => 'bg-danger'];
?>

<main class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>/admin" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Revenue</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Manage Revenue</h2>
            <div class="d-flex gap-2">
                <a href="<?php echo ROOT; ?>/admin/settings" class="btn btn-outline-secondary rounded-pill fw-bold"><i class="fas fa-cog me-2"></i> Receipt Settings</a>
                <button class="btn btn-success rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#walkinModal">
                    <i class="fas fa-plus me-2"></i> Add Walk-in Payment
                </button>
            </div>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <?php $r = $_GET['receipt'] ?? ''; ?>
            <div class="alert alert-<?php echo $r === 'sent' ? 'success' : 'warning'; ?> border-0 shadow-sm rounded-3">
                Payment recorded.
                <?php echo $r === 'sent' ? 'Receipt sent to the client.' : 'The receipt could not be sent (check Receipt Settings, or use Resend later).'; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['resent'])): ?>
            <div class="alert alert-<?php echo $_GET['resent'] === 'sent' ? 'success' : 'warning'; ?> border-0 shadow-sm rounded-3">
                <?php echo $_GET['resent'] === 'sent' ? 'Receipt resent.' : 'Receipt could not be sent.'; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-3">Please enter the client name and an amount greater than zero.</div>
        <?php endif; ?>

        <div class="row g-3 mb-4">
            <div class="col-md-4"><div class="card border-0 shadow-sm rounded-4 p-3"><div class="small text-muted">Total Revenue</div><div class="h5 fw-bold mb-0">GH₵ <?php echo number_format($totals['total'], 2); ?></div></div></div>
            <div class="col-md-4"><div class="card border-0 shadow-sm rounded-4 p-3"><div class="small text-muted">Walk-in</div><div class="h5 fw-bold mb-0">GH₵ <?php echo number_format($totals['walk_in'], 2); ?></div></div></div>
            <div class="col-md-4"><div class="card border-0 shadow-sm rounded-4 p-3"><div class="small text-muted">Online</div><div class="h5 fw-bold mb-0">GH₵ <?php echo number_format($totals['online'], 2); ?></div></div></div>
        </div>

        <form action="<?php echo ROOT; ?>/admin/revenue" method="GET" class="mb-4">
            <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white">
                <span class="input-group-text border-0 bg-transparent ps-4"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="q" class="form-control border-0 bg-transparent py-2 shadow-none" placeholder="Search by name, phone, email, service or reference..." value="<?php echo htmlspecialchars($search); ?>">
                <select name="source" class="form-select border-0 bg-transparent shadow-none" style="max-width:150px" onchange="this.form.submit()">
                    <option value="">All sources</option>
                    <option value="walk_in" <?php echo $source === 'walk_in' ? 'selected' : ''; ?>>Walk-in</option>
                    <option value="online" <?php echo $source === 'online' ? 'selected' : ''; ?>>Online</option>
                </select>
                <?php if (!empty($search) || !empty($source)): ?>
                    <a href="<?php echo ROOT; ?>/admin/revenue" class="btn border-0 bg-transparent text-muted py-2 d-flex align-items-center" title="Clear"><i class="fas fa-times"></i></a>
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
                                <th class="ps-4">ID</th>
                                <th>Client</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Source</th>
                                <th>Payment</th>
                                <th>Receipt</th>
                                <th>Date</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($items)): ?>
                                <tr><td colspan="9" class="text-center py-5 text-muted"><?php echo (!empty($search) || !empty($source)) ? 'No transactions match your search.' : 'No transactions yet.'; ?></td></tr>
                            <?php else: ?>
                                <?php foreach ($items as $t): ?>
                                    <tr>
                                        <td class="ps-4 small text-muted">#<?php echo str_pad($t['id'], 6, '0', STR_PAD_LEFT); ?></td>
                                        <td>
                                            <span class="fw-bold"><?php echo htmlspecialchars($t['client_name']); ?></span>
                                            <span class="small text-muted d-block"><?php echo htmlspecialchars($t['mobile_number'] ?? ''); ?></span>
                                            <span class="small text-muted d-block"><?php echo htmlspecialchars($t['email'] ?? ''); ?></span>
                                        </td>
                                        <td class="small"><?php echo htmlspecialchars($t['description']); ?></td>
                                        <td class="fw-bold text-nowrap">GH₵ <?php echo number_format($t['amount'], 2); ?></td>
                                        <td><span class="badge <?php echo $t['payment_source'] === 'online' ? 'bg-info text-dark' : 'bg-dark'; ?>"><?php echo $t['payment_source'] === 'online' ? 'Online' : 'Walk-in'; ?></span></td>
                                        <td><span class="badge <?php echo $t['payment_status'] === 'paid' ? 'bg-success' : ($t['payment_status'] === 'failed' ? 'bg-danger' : 'bg-warning text-dark'); ?>"><?php echo ucfirst($t['payment_status']); ?></span></td>
                                        <td>
                                            <span class="badge <?php echo $badge[$t['receipt_status']]; ?>"><?php echo ucfirst($t['receipt_status']); ?></span>
                                            <span class="small text-muted d-block">SMS: <?php echo htmlspecialchars($t['sms_status']); ?> · Email: <?php echo htmlspecialchars($t['email_status']); ?></span>
                                        </td>
                                        <td class="small text-muted text-nowrap"><?php echo date('M d, Y h:i A', strtotime($t['created_at'])); ?></td>
                                        <td class="text-end pe-4 text-nowrap">
                                            <a href="<?php echo ROOT; ?>/receipts/<?php echo $t['receipt_token']; ?>" target="_blank" class="btn btn-sm btn-light border-0" title="View receipt"><i class="fas fa-receipt"></i></a>
                                            <a href="<?php echo ROOT; ?>/admin/revenue_resend/<?php echo $t['id']; ?>" class="btn btn-sm btn-outline-primary border-0" title="Resend receipt" onclick="return confirm('Resend the receipt by SMS and email?')"><i class="fas fa-paper-plane"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if ($totalPages > 1): ?>
                <div class="card-footer bg-white border-0 rounded-bottom-4 d-flex flex-wrap justify-content-between align-items-center gap-2 px-4 py-3">
                    <small class="text-muted">Page <?php echo $page; ?> of <?php echo $totalPages; ?> (<?php echo $total; ?> transactions)</small>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>"><a class="page-link" href="?page=<?php echo $page - 1 . $qs; ?>">&laquo;</a></li>
                        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $i . $qs; ?>"><?php echo $i; ?></a></li>
                        <?php endfor; ?>
                        <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>"><a class="page-link" href="?page=<?php echo $page + 1 . $qs; ?>">&raquo;</a></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<div class="modal fade" id="walkinModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Add Walk-in Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo ROOT; ?>/admin/revenue" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Client Name *</label>
                        <input type="text" name="client_name" class="form-control" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Mobile Number</label>
                            <input type="tel" name="mobile_number" class="form-control" placeholder="024XXXXXXX">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Description *</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="e.g. ADHD Assessment - Walk-in" required></textarea>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold">Amount (GH₵) *</label>
                        <input type="number" step="0.01" min="0.01" name="amount" class="form-control" required>
                    </div>
                    <div class="form-text mt-3">A receipt link will be sent by SMS and email to the details above.</div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 pe-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="add_walkin" class="btn btn-success rounded-pill px-5 fw-bold">Save &amp; Send Receipt</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>
