<?php require_once '../app/views/layout/header.php'; ?>

<!-- Hero Section -->
<section class="py-5 bg-dark text-white text-center">
    <div class="container py-4">
        <h1 class="fw-bold display-4 mb-3">Resources & Downloads</h1>
        <p class="lead opacity-75">Access and download important documents and resources</p>
    </div>
</section>

<main class="py-5 bg-light">
    <div class="container py-4">
        <div class="row g-4 justify-content-center">
            <?php if (empty($items)): ?>
                <div class="col-12 text-center py-5">
                    <div class="mb-3 text-muted">
                        <i class="fas fa-file-download fa-4x opacity-25"></i>
                    </div>
                    <h4 class="text-muted">No downloads available yet</h4>
                </div>
            <?php else: ?>
                <?php foreach ($items as $item): ?>
                    <div class="col-md-8">
                        <div class="card border-0 shadow-sm rounded-4 hover-lift">
                            <div class="card-body p-4 d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-4 p-3 me-4">
                                    <i class="fas fa-file-pdf fa-2x"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-1" style="cursor: pointer;" onclick="showDescription('<?php echo htmlspecialchars(addslashes($item['title'])); ?>', '<?php echo htmlspecialchars(addslashes($item['description'])); ?>')"><?php echo htmlspecialchars($item['title']); ?></h5>
                                    <p class="text-muted small mb-0" style="cursor: pointer;" onclick="showDescription('<?php echo htmlspecialchars(addslashes($item['title'])); ?>', '<?php echo htmlspecialchars(addslashes($item['description'])); ?>')">
                                        <?php 
                                            $desc = strip_tags($item['description']);
                                            echo strlen($desc) > 100 ? substr($desc, 0, 100) . '...' : $desc; 
                                        ?>
                                    </p>
                                </div>
                                <div>
                                    <button onclick="previewFile('<?php echo ROOT . '/' . $item['file_path']; ?>', '<?php echo htmlspecialchars($item['title']); ?>')" class="btn btn-primary rounded-pill px-4">
                                        <i class="fas fa-eye me-2"></i> Preview
                                    </button>
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
                <h5 class="modal-title fw-bold text-primary" id="descModalTitle"></h5>
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

<?php require_once '../app/views/layout/footer.php'; ?>
