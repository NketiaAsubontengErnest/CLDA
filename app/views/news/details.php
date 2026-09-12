<?php require_once '../app/views/layout/header.php'; ?>

<main class="py-5 bg-white">
    <div class="container py-4">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>/news" class="text-decoration-none">News & Events</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($item['title']); ?></li>
            </ol>
        </nav>

        <article class="mx-auto" style="max-width: 800px;">
            <h1 class="fw-bold display-5 mb-3"><?php echo htmlspecialchars($item['title']); ?></h1>
            
            <div class="d-flex align-items-center text-muted mb-4">
                <span class="me-3"><i class="far fa-calendar-alt me-2"></i> <?php echo date('F d, Y', strtotime($item['created_at'])); ?></span>
                <span class="badge bg-primary rounded-pill fw-normal">News</span>
            </div>

            <?php if ($item['image_path']): ?>
                <div class="mb-5 rounded-4 overflow-hidden border shadow-sm">
                    <img src="<?php echo ROOT . '/' . $item['image_path']; ?>" class="img-fluid w-100" alt="<?php echo htmlspecialchars($item['title']); ?>">
                </div>
            <?php endif; ?>

            <div class="article-content lead text-muted">
                <?php echo $item['content']; ?>
            </div>

            <hr class="my-5">

            <div class="text-center">
                <a href="<?php echo ROOT; ?>/news" class="btn btn-outline-primary rounded-pill px-5">
                    <i class="fas fa-arrow-left me-2"></i> Back to News
                </a>
            </div>
        </article>
    </div>
</main>

<style>
    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        margin: 20px 0;
    }
</style>

<?php require_once '../app/views/layout/footer.php'; ?>
