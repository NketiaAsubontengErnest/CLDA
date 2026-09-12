<?php require_once 'layout/header.php'; ?>

<!-- Hero Section -->
<section class="py-5 bg-light text-center" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('<?php echo ROOT; ?>/public/assets/img/hero_children_learning_png_1770984020174.jpg') no-repeat center center; background-size: cover; color: white;">
    <div class="container py-5">
        <h1 class="fw-bold display-3 mb-3 text-white">Research & Findings</h1>
        <p class="lead text-white-50">Our contributions to the field of learning disabilities</p>
    </div>
</section>

<main class="py-5 bg-light">
    <div class="container py-4">
        <div class="row g-4">
            <?php if (empty($items)): ?>
                <div class="col-12 text-center py-5">
                    <div class="mb-3 text-muted">
                        <i class="fas fa-microscope fa-4x opacity-25"></i>
                    </div>
                    <h4 class="text-muted">No research papers available yet</h4>
                </div>
            <?php else: ?>
                <?php foreach ($items as $item): ?>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden hover-lift">
                            <div class="card-body p-4">
                                <h4 class="fw-bold text-success mb-3">
                                    <?php echo htmlspecialchars($item['title']); ?>
                                </h4>
                                <div class="text-muted mb-4 small" style="cursor: pointer;" onclick="showDescription('<?php echo htmlspecialchars(addslashes($item['title'])); ?>', '<?php echo htmlspecialchars(addslashes($item['description'])); ?>')">
                                    <?php 
                                        $desc = strip_tags($item['description']);
                                        echo strlen($desc) > 150 ? substr($desc, 0, 150) . '... <span class="text-primary fw-bold">Read More</span>' : $desc; 
                                    ?>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small"><i class="far fa-calendar-alt me-1"></i> Published: <?php echo date('M Y', strtotime($item['created_at'])); ?></span>
                                    <?php if ($item['file_path']): ?>
                                        <button onclick="previewFile('<?php echo ROOT . '/' . $item['file_path']; ?>', '<?php echo htmlspecialchars($item['title']); ?>')" class="btn btn-success text-white rounded-pill px-4">
                                            <i class="fas fa-eye me-2"></i> Preview
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- Description Modal -->
<div class="modal fade" id="descriptionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-success" id="descModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-muted lead" id="descModalBody">
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showDescription(title, description) {
        document.getElementById('descModalTitle').innerText = title;
        document.getElementById('descModalBody').innerHTML = description;
        var modal = new bootstrap.Modal(document.getElementById('descriptionModal'));
        modal.show();
    }
</script>


<?php require_once 'layout/footer.php'; ?>
