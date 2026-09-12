<?php include 'layout/header.php'; ?>

<style>
    .pricing-header {
        background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);
        padding: 100px 0 150px;
        color: white;
        text-align: center;
    }
    
    .pricing-container {
        margin-top: -100px;
        position: relative;
        z-index: 10;
        padding-bottom: 80px;
    }
    
    .pricing-card {
        border: none;
        border-radius: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        background: white;
    }
    
    .pricing-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
    }
    
    .pricing-card.featured {
        border: 2px solid #0d6efd;
        transform: scale(1.05);
    }
    
    .pricing-card.featured:hover {
        transform: scale(1.05) translateY(-10px);
    }
    
    .price-tag {
        font-size: 3.5rem;
        font-weight: 800;
        color: #0d6efd;
    }
    
    .price-currency {
        font-size: 1.5rem;
        vertical-align: top;
        margin-top: 10px;
        display: inline-block;
    }
    
    .pricing-features li {
        padding: 12px 0;
        border-bottom: 1px solid #f1f3f5;
        color: #495057;
    }
    
    .pricing-features li:last-child {
        border-bottom: none;
    }
    
    .pricing-features i {
        color: #28a745;
        margin-right: 10px;
    }
    
    .faq-section {
        background-color: #f8f9fa;
        padding: 80px 0;
    }
    
    .faq-card {
        border: none;
        border-radius: 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
</style>

<!-- Header -->
<header class="pricing-header">
    <div class="container">
        <h1 class="display-4 fw-bold">Simple, Transparent Pricing</h1>
        <p class="lead opacity-75">Invest in your child's future with our expert assessment packages.</p>
    </div>
</header>

<!-- Pricing Tables -->
<section class="pricing-container">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <?php if (empty($tests)): ?>
                <div class="col-12 text-center py-5">
                    <div class="bg-white rounded-4 p-5 shadow-sm">
                        <p class="h5 text-muted">No assessment packages are currently listed.</p>
                        <a href="<?php echo ROOT; ?>/contact" class="btn btn-primary mt-3">Contact us for pricing</a>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($tests as $index => $test): ?>
                    <div class="col-lg-4">
                        <div class="card pricing-card <?php echo ($index == 1) ? 'featured shadow' : 'shadow-sm'; ?> h-100">
                            <?php if ($index == 1): ?>
                                <div class="bg-primary text-white text-center py-2 fw-bold small text-uppercase">Recommended</div>
                            <?php endif; ?>
                            <div class="card-body p-5 d-flex flex-column">
                                <div class="text-uppercase fw-bold <?php echo ($index == 1) ? 'text-primary' : 'text-muted'; ?> mb-3 small tracking-widest d-flex flex-wrap gap-1 align-items-center">
                                    Assessment Package
                                    <?php if (!empty($test['tags'])): ?>
                                        <?php foreach (explode(',', $test['tags']) as $tag): ?>
                                            <span class="badge bg-light text-muted border fw-normal ms-1" style="font-size: 0.6rem; text-transform: none;"><?php echo htmlspecialchars(trim($tag)); ?></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <h3 class="fw-bold mb-4"><?php echo htmlspecialchars($test['title']); ?></h3>
                                <div class="mb-4">
                                    <span class="price-currency">GH₵</span>
                                    <span class="price-tag"><?php echo number_format($test['price'], 0); ?></span>
                                </div>
                                <p class="text-muted mb-4 flex-grow-1">
                                    <?php echo nl2br(htmlspecialchars($test['description'])); ?>
                                </p>
                                <a href="<?php echo ROOT; ?>/tests/take/<?php echo $test['id']; ?>" class="btn <?php echo ($index == 1) ? 'btn-primary shadow-sm' : 'btn-outline-primary'; ?> w-100 rounded-pill py-3 fw-bold">
                                    Select Package
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="faq-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="text-center fw-bold mb-5">Frequently Asked Questions</h2>
                
                <div class="accordion accordion-flush" id="pricingFaq">
                    <div class="accordion-item faq-card overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Are these one-time fees?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#pricingFaq">
                            <div class="accordion-body text-muted">
                                Yes, the assessment package fees are one-time payments for the entire process, including testing, report generation, and feedback sessions.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item faq-card overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Do you offer payment plans?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#pricingFaq">
                            <div class="accordion-body text-muted">
                                We believe every child deserves support. Please contact our finance office to discuss flexible payment arrangements or sliding-scale fees for eligible families.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item faq-card overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Is insurance accepted?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#pricingFaq">
                            <div class="accordion-body text-muted">
                                While we do not bill insurance directly, we provide a detailed invoice and clinical summary that you can submit to your provider for potential reimbursement.
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-5">
                    <p class="text-muted mb-4">Have more specific questions about our fees?</p>
                    <a href="<?php echo ROOT; ?>/contact" class="btn btn-link text-primary fw-bold text-decoration-none">Talk to our team <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5 bg-white border-top">
    <div class="container text-center py-4">
        <h3 class="fw-bold mb-3">Ready to unlock your child's potential?</h3>
        <p class="text-muted mb-4 mx-auto" style="max-width: 600px;">Schedule your consultation today and take the first step towards personalized learning success.</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="https://calendar.app.google/oNQgmMUEVmvg8HA69" target="_blank" class="btn btn-book">Book Appointment</a>
            <a href="<?php echo ROOT; ?>/contact" class="btn btn-outline-dark rounded-pill px-4 fw-bold">Contact Us</a>
        </div>
    </div>
</section>

<?php include 'layout/footer.php'; ?>
