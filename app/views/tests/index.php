<?php require_once '../app/views/layout/header.php'; ?>

<main class="py-5" style="min-height: 80vh;">
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="fw-bold">Online Assessments</h1>
            <p class="text-muted lead">Take our specialized assessments to get professional insights.</p>
        </div>

        <div class="row mb-5 justify-content-center">
            <div class="col-md-8">
                <form action="<?php echo ROOT; ?>/tests" method="GET" class="position-relative mb-4">
                    <input type="text" name="q" class="form-control form-control-lg rounded-pill ps-4 shadow-sm border-0" placeholder="Search" value="<?php echo htmlspecialchars($search ?? ''); ?>">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 position-absolute top-50 end-0 translate-middle-y me-1 shadow-sm" style="height: calc(100% - 8px);">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                
                <?php if (!empty($distinct_tags)): ?>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <a href="<?php echo ROOT; ?>/tests" class="tag-pill <?php echo empty($search) ? 'active' : ''; ?>">All</a>
                        <?php foreach ($distinct_tags as $tag): ?>
                            <a href="<?php echo ROOT; ?>/tests?q=<?php echo urlencode($tag); ?>" 
                               class="tag-pill <?php echo ($search === $tag) ? 'active' : ''; ?>">
                                <?php echo htmlspecialchars($tag); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            <?php if (empty($tests)): ?>
                <div class="col-12 text-center py-5">
                    <div class="bg-light rounded-4 p-5 d-inline-block">
                        <i class="fas fa-search fa-4x text-muted mb-3 opacity-25"></i>
                        <p class="h5 text-muted">No assessments found.</p>
                        <p class="small text-muted"><?php echo isset($search) ? 'Try adjusting your search query.' : 'Please check back later.'; ?></p>
                        <?php if (isset($search)): ?>
                            <a href="<?php echo ROOT; ?>/tests" class="btn btn-link text-decoration-none">Clear search</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($tests as $test): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border shadow-sm rounded-4 hover-lift test-card">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="mb-3 d-flex flex-wrap gap-1">
                                    <?php if (!empty($test['tags'])): ?>
                                        <?php foreach (explode(',', $test['tags']) as $tag): ?>
                                            <a href="<?php echo ROOT; ?>/tests?q=<?php echo urlencode(trim($tag)); ?>" class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1 small fw-normal text-decoration-none hover-primary"><?php echo htmlspecialchars(trim($tag)); ?></a>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <h6 class="card-title fw-bold mb-3 lh-base"><?php echo htmlspecialchars($test['title']); ?></h6>
                                <p class="card-text text-muted flex-grow-1" style="font-size: 0.85rem;">
                                    <?php echo nl2br(htmlspecialchars($test['description'])); ?>
                                </p>
                                <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem;">Price</small>
                                        <span class="fw-bold text-dark" style="font-size: 1rem;">GH₵ <?php echo number_format($test['price'], 2); ?></span>
                                    </div>
                                    <a href="<?php echo ROOT; ?>/tests/take/<?php echo $test['id']; ?>" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">
                                        Start Now <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<style>
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .tag-pill {
        padding: 8px 20px;
        border-radius: 50px;
        background: white;
        color: #0d6efd;
        border: 1px solid #dee2e6;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .tag-pill:hover, .tag-pill.active {
        background: #0d6efd;
        color: white;
        border-color: #0d6efd;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.2);
    }
    .hover-primary:hover {
        background-color: #0d6efd !important;
        color: white !important;
    }
    .test-card {
        border-color: #e3f2fd !important; /* Very light blue */
        border-top: 4px solid #90caf9 !important; /* Light blue top border */
    }
</style>

<?php require_once '../app/views/layout/footer.php'; ?>
