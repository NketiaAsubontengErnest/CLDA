<?php require_once '../app/views/layout/header.php'; ?>
<?php
$totalGross = array_sum(array_column($records, 'gross_pay'));
$totalDed = array_sum(array_column($records, 'total_deductions'));
$totalNet = array_sum(array_column($records, 'net_pay'));
?>

<main class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>/admin" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Payroll</li>
            </ol>
        </nav>

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <h2 class="fw-bold mb-0">Payroll</h2>
            <div class="d-flex flex-wrap gap-2">
                <form action="<?php echo ROOT; ?>/admin/payroll" method="GET" class="d-flex gap-2">
                    <input type="month" name="month" class="form-control rounded-pill" value="<?php echo htmlspecialchars($month); ?>" onchange="this.form.submit()">
                </form>
                <form action="<?php echo ROOT; ?>/admin/payroll" method="POST">
                    <input type="hidden" name="month" value="<?php echo htmlspecialchars($month); ?>">
                    <button type="submit" name="generate" class="btn btn-primary rounded-pill fw-bold" onclick="return confirm('Generate payroll for all active employees for this month?')">
                        <i class="fas fa-cogs me-2"></i> Generate Payroll
                    </button>
                </form>
                <a href="<?php echo ROOT; ?>/admin/employees" class="btn btn-outline-dark rounded-pill fw-bold">
                    <i class="fas fa-users me-2"></i> Employees
                </a>
            </div>
        </div>

        <?php if (isset($_GET['generated'])): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-3"><?php echo (int)$_GET['generated']; ?> payroll record(s) generated.</div>
        <?php endif; ?>
        <?php if (isset($_GET['updated'])): ?>
            <div class="alert alert-info border-0 shadow-sm rounded-3">Payroll updated.</div>
        <?php endif; ?>
        <?php if (isset($_GET['locked'])): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-3">This record can no longer be deleted: payroll can only be deleted within 24 hours of being generated.</div>
        <?php endif; ?>
        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert alert-warning border-0 shadow-sm rounded-3">Payroll record deleted.</div>
        <?php endif; ?>

        <div class="row g-3 mb-4">
            <div class="col-md-4"><div class="card border-0 shadow-sm rounded-4 p-3"><div class="small text-muted">Total Gross</div><div class="h5 fw-bold mb-0">GH₵ <?php echo number_format($totalGross, 2); ?></div></div></div>
            <div class="col-md-4"><div class="card border-0 shadow-sm rounded-4 p-3"><div class="small text-muted">Total Deductions</div><div class="h5 fw-bold mb-0">GH₵ <?php echo number_format($totalDed, 2); ?></div></div></div>
            <div class="col-md-4"><div class="card border-0 shadow-sm rounded-4 p-3"><div class="small text-muted">Total Net Pay</div><div class="h5 fw-bold text-success mb-0">GH₵ <?php echo number_format($totalNet, 2); ?></div></div></div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Employee</th>
                                <th>Gross</th>
                                <th>SSNIT</th>
                                <th>PAYE</th>
                                <th>Other</th>
                                <th>Net Pay</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($records)): ?>
                                <tr><td colspan="8" class="text-center py-5 text-muted">No payroll for <?php echo htmlspecialchars(date('F Y', strtotime($month . '-01'))); ?>. Click "Generate Payroll".</td></tr>
                            <?php else: ?>
                                <?php foreach ($records as $r): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <span class="fw-bold"><?php echo htmlspecialchars($r['full_name']); ?></span>
                                            <span class="small text-muted d-block"><?php echo htmlspecialchars($r['employee_code']); ?></span>
                                        </td>
                                        <td class="small"><?php echo number_format($r['gross_pay'], 2); ?></td>
                                        <td class="small"><?php echo number_format($r['ssnit_employee'], 2); ?></td>
                                        <td class="small"><?php echo number_format($r['income_tax'], 2); ?></td>
                                        <td class="small"><?php echo number_format($r['other_deductions'], 2); ?></td>
                                        <td class="fw-bold"><?php echo number_format($r['net_pay'], 2); ?></td>
                                        <td><span class="badge <?php echo $r['status'] === 'paid' ? 'bg-success' : 'bg-warning text-dark'; ?>"><?php echo ucfirst($r['status']); ?></span></td>
                                        <td class="text-end pe-4 text-nowrap">
                                            <button class="btn btn-sm btn-light border-0" title="Adjust bonus / deductions" onclick='adjustRecord(<?php echo htmlspecialchars(json_encode($r), ENT_QUOTES, "UTF-8"); ?>)'><i class="fas fa-edit"></i></button>
                                            <a href="<?php echo ROOT; ?>/admin/payslip/<?php echo $r['id']; ?>" target="_blank" class="btn btn-sm btn-light border-0" title="Payslip"><i class="fas fa-print"></i></a>
                                            <?php if ($r['status'] !== 'paid'): ?>
                                                <a href="<?php echo ROOT; ?>/admin/payroll_paid/<?php echo $r['id']; ?>" class="btn btn-sm btn-outline-success border-0" title="Mark as paid" onclick="return confirm('Mark as paid?')"><i class="fas fa-check"></i></a>
                                            <?php endif; ?>
                                            <?php if (!empty($r['deletable'])): ?>
                                                <a href="<?php echo ROOT; ?>/admin/payroll_delete/<?php echo $r['id']; ?>" class="btn btn-sm btn-outline-danger border-0" title="Can be deleted within 24 hours of generation" onclick="return confirm('Delete this payroll record?')"><i class="fas fa-trash"></i></a>
                                            <?php else: ?>
                                                <span class="btn btn-sm border-0 disabled text-muted" title="Locked: more than 24 hours since generation"><i class="fas fa-lock"></i></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <p class="small text-muted mt-3">SSNIT (5.5% of basic) and PAYE are calculated automatically using Ghana monthly rates.</p>
    </div>
</main>

<div class="modal fade" id="adjustModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="adjustTitle">Adjust Payroll</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo ROOT; ?>/admin/payroll" method="POST">
                <input type="hidden" name="id" id="adjId">
                <input type="hidden" name="month" value="<?php echo htmlspecialchars($month); ?>">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Bonus (GH₵)</label>
                        <input type="number" step="0.01" min="0" name="bonus" id="adjBonus" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Other Deductions (GH₵)</label>
                        <input type="number" step="0.01" min="0" name="other_deductions" id="adjOther" class="form-control" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold">Notes</label>
                        <textarea name="notes" id="adjNotes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 pe-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="adjust" class="btn btn-primary rounded-pill px-5 fw-bold">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function adjustRecord(r) {
        document.getElementById('adjustTitle').innerText = 'Adjust: ' + r.full_name;
        document.getElementById('adjId').value = r.id;
        document.getElementById('adjBonus').value = r.bonus;
        document.getElementById('adjOther').value = r.other_deductions;
        document.getElementById('adjNotes').value = r.notes || '';
        new bootstrap.Modal(document.getElementById('adjustModal')).show();
    }
</script>

<?php require_once '../app/views/layout/footer.php'; ?>
