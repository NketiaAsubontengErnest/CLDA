<?php require_once '../app/views/layout/header.php'; ?>

<!-- Hero Section -->
<section class="py-5 bg-info text-white text-center">
    <div class="container py-4">
        <h1 class="fw-bold display-4 mb-3">Media & Events Gallery</h1>
        <p class="lead opacity-75">Glimpses of our activities and upcoming events</p>
    </div>
</section>

<main class="py-5 bg-light">
    <div class="container py-4">

        <!-- Media Section -->
        <div>
            <h2 class="fw-bold mb-4 border-bottom pb-2 text-primary">Photo & Video Gallery</h2>
            <div class="row g-3">
                <?php if (empty($media)): ?>
                    <div class="col-12 text-muted">No media items in gallery yet.</div>
                <?php else: ?>
                    <?php foreach ($media as $item): ?>
                        <div class="col-md-3">
                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 gallery-item" 
                                 onclick="previewFile('<?php echo ROOT . '/' . $item['file_path']; ?>', '<?php echo htmlspecialchars($item['title']); ?>')">
                                <?php if ($item['type'] == 'image'): ?>
                                    <img src="<?php echo ROOT . '/' . $item['file_path']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-dark d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-play fa-3x text-white"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body p-3 text-center">
                                    <h6 class="fw-bold mb-0 small"><?php echo htmlspecialchars($item['title']); ?></h6>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<style>
    .gallery-item:hover {
        transform: scale(1.02);
        transition: transform 0.3s ease;
        cursor: pointer;
    }
</style>

<?php require_once '../app/views/layout/footer.php'; ?>
