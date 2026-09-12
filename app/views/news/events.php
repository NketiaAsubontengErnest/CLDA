<?php require_once '../app/views/layout/header.php'; ?>

<!-- Hero Section -->
<section class="py-5 bg-danger text-white text-center">
    <div class="container py-4">
        <h1 class="fw-bold display-4 mb-3">Upcoming Events</h1>
        <p class="lead opacity-75">Stay informed about our latest programs and workshops</p>
    </div>
</section>

<main class="py-5 bg-light">
    <div class="container py-4">
        <div class="row g-4">
            <?php if (empty($events)): ?>
                <div class="col-12 text-center py-5">
                    <div class="mb-3 text-muted">
                        <i class="far fa-calendar-times fa-4x opacity-25"></i>
                    </div>
                    <h4 class="text-muted">No upcoming events scheduled.</h4>
                    <p class="text-muted">Check back later for new announcements.</p>
                </div>
            <?php else: ?>
                <?php foreach ($events as $event): ?>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden hover-lift">
                            <div class="bg-danger text-white p-3 text-center">
                                <div class="display-6 fw-bold"><?php echo date('d', strtotime($event['event_date'])); ?></div>
                                <div class="small fw-bold letter-spacing-1"><?php echo strtoupper(date('M Y', strtotime($event['event_date']))); ?></div>
                            </div>
                            <div class="card-body p-4 d-flex flex-column">
                                <h5 class="fw-bold mb-3"><?php echo htmlspecialchars($event['title']); ?></h5>
                                <div class="mb-3 text-muted small">
                                    <i class="fas fa-map-marker-alt me-2 text-danger"></i> <?php echo htmlspecialchars($event['location']); ?>
                                </div>
                                <div class="card-text text-muted flex-grow-1">
                                    <?php echo $event['description']; ?>
                                </div>
                                <div class="mt-4">
                                    <a href="<?php echo ROOT; ?>/contact" class="btn btn-outline-danger w-100 rounded-pill">Register Interest</a>
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
    .letter-spacing-1 {
        letter-spacing: 1px;
    }
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>

<?php require_once '../app/views/layout/footer.php'; ?>
