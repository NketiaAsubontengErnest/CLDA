<?php
/** @var array $txn */
$id = '#' . str_pad($txn['id'], 6, '0', STR_PAD_LEFT);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Receipt <?php echo $id; ?> - Center for Learning Disabilities</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f4f4; }
        .receipt { max-width: 640px; margin: 30px auto; background: #fff; padding: 40px; border: 1px solid #ddd; border-radius: 12px; }
        .paid { color: #198754; border: 3px solid #198754; padding: 2px 14px; font-weight: 700; letter-spacing: 2px; transform: rotate(-6deg); display: inline-block; }
        @media print { body { background: #fff; } .receipt { border: 0; margin: 0; } .no-print { display: none; } }
    </style>
</head>
<body>
<div class="receipt">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="fw-bold mb-0">Center for Learning Disabilities</h4>
            <div class="text-muted small">Official Payment Receipt</div>
        </div>
        <?php if ($txn['payment_status'] === 'paid'): ?><span class="paid">PAID</span><?php endif; ?>
    </div>

    <table class="table table-borderless small mb-4">
        <tr><td class="text-muted" style="width:40%">Receipt No.</td><td class="text-end fw-bold"><?php echo $id; ?></td></tr>
        <tr><td class="text-muted">Date</td><td class="text-end"><?php echo date('F d, Y h:i A', strtotime($txn['created_at'])); ?></td></tr>
        <tr><td class="text-muted">Received From</td><td class="text-end"><?php echo htmlspecialchars($txn['client_name']); ?></td></tr>
        <?php if (!empty($txn['mobile_number'])): ?><tr><td class="text-muted">Mobile</td><td class="text-end"><?php echo htmlspecialchars($txn['mobile_number']); ?></td></tr><?php endif; ?>
        <?php if (!empty($txn['email'])): ?><tr><td class="text-muted">Email</td><td class="text-end"><?php echo htmlspecialchars($txn['email']); ?></td></tr><?php endif; ?>
        <tr><td class="text-muted">Service</td><td class="text-end"><?php echo htmlspecialchars($txn['description']); ?></td></tr>
        <tr><td class="text-muted">Payment Method</td><td class="text-end"><?php echo $txn['payment_source'] === 'online' ? 'Online' : 'Walk-in'; ?></td></tr>
        <?php if (!empty($txn['reference'])): ?><tr><td class="text-muted">Reference</td><td class="text-end"><?php echo htmlspecialchars($txn['reference']); ?></td></tr><?php endif; ?>
    </table>

    <div class="d-flex justify-content-between align-items-center border-top border-2 pt-3">
        <span class="h5 fw-bold mb-0">Amount Paid</span>
        <span class="h4 fw-bold text-success mb-0">GH₵ <?php echo number_format($txn['amount'], 2); ?></span>
    </div>

    <p class="text-center text-muted small mt-4 mb-0">Thank you for your payment.</p>

    <div class="text-center mt-4 no-print">
        <button onclick="window.print()" class="btn btn-primary rounded-pill px-4">Print / Save as PDF</button>
    </div>
</div>
</body>
</html>
