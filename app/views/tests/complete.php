<?php require_once '../app/views/layout/header.php'; ?>

<main class="py-5" style="min-height: 80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 text-center">
                <div class="card border-0 shadow rounded-4 p-4 p-md-5">
                    <div class="mb-4 text-success">
                        <i class="fas fa-check-circle fa-5x"></i>
                    </div>
                    <h2 class="fw-bold mb-3">Submission Received!</h2>
                    <p class="text-muted mb-4 lead">
                        Thank you for completing the assessment. Your responses have been recorded.
                    </p>
                    
                    <div class="bg-light rounded-4 p-4 mb-4 text-start">
                        <h5 class="fw-bold mb-3 text-center">Next Steps & Payment</h5>
                        <p class="small text-muted mb-3">
                            To receive your comprehensive report and analysis, a payment of <strong class="text-dark">GH₵ <?php echo number_format($submission['price'] ?? 100.00, 2); // Default or fetch form DB ?></strong> is required.
                        </p>
                        
                        <?php if (isset($_GET['payment']) && $_GET['payment'] == 'success'): ?>
                            <div class="alert alert-success fw-bold text-center">
                                <i class="fas fa-check-circle me-2"></i> Payment Successful! We will send your report shortly.
                            </div>
                        <?php elseif ($submission['status'] == 'paid'): ?>
                            <div class="alert alert-success fw-bold text-center">
                                <i class="fas fa-check-circle me-2"></i> Payment Received.
                            </div>
                        <?php else: ?>
                            <div class="d-flex align-items-center mb-3 p-3 bg-white rounded-3 border">
                                <div class="me-3">
                                    <img src="<?php echo ROOT; ?>/assets/img/momo.png" alt="Momo" height="40" onerror="this.style.display='none'">
                                    <i class="fas fa-credit-card fa-2x text-primary" onerror="this.style.display='block'"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-0">Pay Online</h6>
                                    <p class="mb-0 text-muted small">Secure payment via Paystack</p>
                                </div>
                                <a href="<?php echo ROOT; ?>/tests/initialize_payment/<?php echo $submission['id']; ?>" class="btn btn-primary rounded-pill fw-bold">
                                    Pay Now
                                </a>
                            </div>


                        <?php endif; ?>
                    </div>

                    <a href="<?php echo ROOT; ?>/" class="btn btn-outline-primary rounded-pill px-4 fw-bold">
                        Return to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>
