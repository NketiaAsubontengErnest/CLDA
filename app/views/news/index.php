<?php require_once '../app/views/layout/header.php'; ?>

<!-- Hero Section -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container py-4">
        <h1 class="fw-bold display-4 mb-3">News & Events</h1>
        <p class="lead opacity-75">Stay updated with the latest happenings at CLD</p>
    </div>
</section>

<main class="py-5 bg-light">
    <div class="container py-4">
        <div class="row g-4">
            <?php if (empty($news)): ?>
                <div class="col-12 text-center py-5">
                    <div class="mb-3 text-muted">
                        <i class="fas fa-newspaper fa-4x opacity-25"></i>
                    </div>
                    <h4 class="text-muted">No news articles yet</h4>
                    <p class="text-muted">Check back soon for latest updates.</p>
                </div>
            <?php else: ?>
                <?php foreach ($news as $item): ?>
                    <div class="col-md-4">
                        <article class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                            <?php if ($item['image_path']): ?>
                                <img src="<?php echo ROOT . '/' . $item['image_path']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($item['title']); ?>" style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-newspaper fa-3x text-primary opacity-25"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body p-4">
                                <div class="mb-2">
                                    <span class="badge bg-primary rounded-pill small fw-normal">News</span>
                                    <span class="text-muted small ms-2"><i class="far fa-calendar-alt me-1"></i> <?php echo date('M d, Y', strtotime($item['created_at'])); ?></span>
                                </div>
                                <h5 class="card-title fw-bold mb-3"><?php echo htmlspecialchars($item['title']); ?></h5>
                                <p class="card-text text-muted small mb-4">
                                    <?php 
                                        $excerpt = strip_tags($item['content']);
                                        echo strlen($excerpt) > 120 ? substr($excerpt, 0, 120) . '...' : $excerpt;
                                    ?>
                                </p>
                                <a href="<?php echo ROOT; ?>/news/details/<?php echo $item['id']; ?>" class="btn btn-outline-primary rounded-pill btn-sm px-4">Read More</a>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once '../app/views/layout/footer.php'; ?>
