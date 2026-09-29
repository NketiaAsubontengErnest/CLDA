<?php
/** @var array $record */
$m = function ($v) { return 'GH₵ ' . number_format($v, 2); };
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip - <?php echo htmlspecialchars($record['full_name']); ?> - <?php echo htmlspecialchars($record['pay_month']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f4f4; }
        .slip { max-width: 800px; margin: 30px auto; background: #fff; padding: 40px; border: 1px solid #ddd; }
        @media print { body { background: #fff; } .slip { border: 0; margin: 0; } .no-print { display: none; } }
    </style>
</head>
<body>
<div class="slip">
    <div class="text-center mb-4 pb-3 border-bottom border-2">
        <img src="<?php echo ROOT; ?>/assets/img/logo.png" alt="CLD Logo" style="height: 90px; margin-bottom: 10px;">
        <h4 class="fw-bold mb-0">Center for Learning Disabilities</h4>
        <div class="text-muted">Payslip for <?php echo htmlspecialchars(date('F Y', strtotime($record['pay_month'] . '-01'))); ?></div>
    </div>

    <div class="row mb-4 small">
        <div class="col-6">
            <div><strong>Name:</strong> <?php echo htmlspecialchars($record['full_name']); ?></div>
            <div><strong>Employee Number:</strong> <?php echo htmlspecialchars($record['employee_code']); ?></div>
            <div><strong>Position:</strong> <?php echo htmlspecialchars($record['position'] ?? ''); ?></div>
            <div><strong>Department:</strong> <?php echo htmlspecialchars($record['department'] ?? ''); ?></div>
        </div>
        <div class="col-6">
            <div><strong>Bank:</strong> <?php echo htmlspecialchars($record['bank_name'] ?? ''); ?></div>
            <div><strong>Account:</strong> <?php echo htmlspecialchars($record['bank_account'] ?? ''); ?></div>
            <div><strong>SSNIT No.:</strong> <?php echo htmlspecialchars($record['ssnit_number'] ?? ''); ?></div>
            <div><strong>TIN:</strong> <?php echo htmlspecialchars($record['tin_number'] ?? ''); ?></div>
        </div>
    </div>

    <table class="table table-sm">
        <thead class="table-light"><tr><th>Earnings</th><th class="text-end">Amount</th></tr></thead>
        <tbody>
            <tr><td>Basic Salary</td><td class="text-end"><?php echo $m($record['basic_salary']); ?></td></tr>
            <tr><td>Allowances</td><td class="text-end"><?php echo $m($record['allowances']); ?></td></tr>
            <tr><td>Bonus</td><td class="text-end"><?php echo $m($record['bonus']); ?></td></tr>
            <tr class="fw-bold"><td>Gross Pay</td><td class="text-end"><?php echo $m($record['gross_pay']); ?></td></tr>
        </tbody>
    </table>

    <table class="table table-sm">
        <thead class="table-light"><tr><th>Deductions</th><th class="text-end">Amount</th></tr></thead>
        <tbody>
            <tr><td>SSNIT (5.5%)</td><td class="text-end"><?php echo $m($record['ssnit_employee']); ?></td></tr>
            <tr><td>PAYE Income Tax</td><td class="text-end"><?php echo $m($record['income_tax']); ?></td></tr>
            <tr><td>Other Deductions</td><td class="text-end"><?php echo $m($record['other_deductions']); ?></td></tr>
            <tr class="fw-bold"><td>Total Deductions</td><td class="text-end"><?php echo $m($record['total_deductions']); ?></td></tr>
        </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center border-top border-2 pt-3 mt-3">
        <span class="h5 fw-bold mb-0">Net Pay</span>
        <span class="h4 fw-bold text-success mb-0"><?php echo $m($record['net_pay']); ?></span>
    </div>

    <?php if (!empty($record['notes'])): ?>
        <p class="small text-muted mt-3"><strong>Notes:</strong> <?php echo nl2br(htmlspecialchars($record['notes'])); ?></p>
    <?php endif; ?>
    <p class="small text-muted mt-3 mb-0">Status: <?php echo ucfirst($record['status']); ?><?php echo $record['paid_at'] ? ' on ' . date('M d, Y', strtotime($record['paid_at'])) : ''; ?></p>

    <div class="text-center mt-4 no-print">
        <button onclick="window.print()" class="btn btn-primary">Print Payslip</button>
    </div>
</div>
</body>
</html>
