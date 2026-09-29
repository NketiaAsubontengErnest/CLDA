<?php require_once '../app/views/layout/header.php'; ?>

<main class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold text-dark">Admin Dashboard</h2>
                <p class="text-muted mb-0">Manage website content from here.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="<?php echo ROOT; ?>/admin/settings" class="btn btn-outline-warning px-4 rounded-pill fw-bold">
                    <i class="fas fa-cog me-2"></i> Settings
                </a>
                <a href="<?php echo ROOT; ?>/admin/profile" class="btn btn-outline-primary px-4 rounded-pill fw-bold">
                    <i class="fas fa-user-cog me-2"></i> Profile
                </a>
                <a href="<?php echo ROOT; ?>/admin/logout" class="btn btn-outline-danger px-4 rounded-pill fw-bold">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
            </div>
        </div>

        <div class="row g-4">
            <!-- News Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 rounded-4 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-4 mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-newspaper fa-2x"></i>
                        </div>
                        <h5 class="fw-bold">News</h5>
                        <p class="text-muted small">Update and manage organization news.</p>
                        <a href="<?php echo ROOT; ?>/admin/news" class="btn btn-primary w-100 rounded-3">Manage News</a>
                    </div>
                </div>
            </div>

            <!-- Research Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 rounded-4 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="icon-box bg-success bg-opacity-10 text-success rounded-4 mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-microscope fa-2x"></i>
                        </div>
                        <h5 class="fw-bold">Research</h5>
                        <p class="text-muted small">Upload research papers and findings.</p>
                        <a href="<?php echo ROOT; ?>/admin/research" class="btn btn-success w-100 rounded-3 text-white">Manage Research</a>
                    </div>
                </div>
            </div>

            <!-- Media Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 rounded-4 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="icon-box bg-info bg-opacity-10 text-info rounded-4 mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-photo-video fa-2x"></i>
                        </div>
                        <h5 class="fw-bold">Media</h5>
                        <p class="text-muted small">Gallery and media uploads.</p>
                        <a href="<?php echo ROOT; ?>/admin/media" class="btn btn-info w-100 rounded-3 text-white">Manage Media</a>
                    </div>
                </div>
            </div>

            <!-- Downloads Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 rounded-4 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-4 mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-download fa-2x"></i>
                        </div>
                        <h5 class="fw-bold">Downloads</h5>
                        <p class="text-muted small">Manage resource files for download.</p>
                        <a href="<?php echo ROOT; ?>/admin/downloads" class="btn btn-warning w-100 rounded-3 text-white">Manage Downloads</a>
                    </div>
                </div>
            </div>

            <!-- Online Tests Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 rounded-4 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="icon-box bg-secondary bg-opacity-10 text-secondary rounded-4 mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-tasks fa-2x"></i>
                        </div>
                        <h5 class="fw-bold">Online Tests</h5>
                        <p class="text-muted small">Create and manage questionnaires.</p>
                        <a href="<?php echo ROOT; ?>/admin/tests" class="btn btn-secondary w-100 rounded-3 text-white">Manage Tests</a>
                    </div>
                </div>
            </div>

            <!-- Events Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 rounded-4 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="icon-box bg-danger bg-opacity-10 text-danger rounded-4 mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                        <h5 class="fw-bold">Events</h5>
                        <p class="text-muted small">Schedule and manage upcoming events.</p>
                        <a href="<?php echo ROOT; ?>/admin/events" class="btn btn-danger w-100 rounded-3">Manage Events</a>
                    </div>
                </div>
            </div>

            <!-- Revenue Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 rounded-4 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="icon-box bg-success bg-opacity-10 text-success rounded-4 mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-receipt fa-2x"></i>
                        </div>
                        <h5 class="fw-bold">Revenue</h5>
                        <p class="text-muted small">Walk-in payments, online transactions and receipts.</p>
                        <a href="<?php echo ROOT; ?>/admin/revenue" class="btn btn-success w-100 rounded-3">Manage Revenue</a>
                    </div>
                </div>
            </div>

            <!-- Payroll Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 rounded-4 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="icon-box bg-dark bg-opacity-10 text-dark rounded-4 mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-money-check-alt fa-2x"></i>
                        </div>
                        <h5 class="fw-bold">Payroll</h5>
                        <p class="text-muted small">Manage employee records and monthly payroll.</p>
                        <div class="d-flex gap-2">
                            <a href="<?php echo ROOT; ?>/admin/employees" class="btn btn-outline-dark w-50 rounded-3">Employees</a>
                            <a href="<?php echo ROOT; ?>/admin/payroll" class="btn btn-dark w-50 rounded-3">Payroll</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    .hover-lift:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
    }
</style>

<?php require_once '../app/views/layout/footer.php'; ?>
