<?php require_once '../app/views/layout/header.php'; ?>

<main class="py-5 bg-light" style="min-height: 80vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-primary">Admin Login</h2>
                            <p class="text-muted">Enter your credentials to access the dashboard</p>
                        </div>

                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger border-0 rounded-3 small">
                                <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo ROOT; ?>/admin/login" method="POST">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-user text-muted"></i></span>
                                    <input type="text" name="username" class="form-control bg-light border-0" placeholder="Username" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-lock text-muted"></i></span>
                                    <input type="password" name="password" id="password" class="form-control bg-light border-0" placeholder="Password" required>
                                    <button class="btn btn-light border-0" type="button" id="togglePassword">
                                        <i class="fas fa-eye text-muted" id="eyeIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <script>
                                document.getElementById('togglePassword').addEventListener('click', function (e) {
                                    const password = document.getElementById('password');
                                    const icon = document.getElementById('eyeIcon');
                                    if (password.type === 'password') {
                                        password.type = 'text';
                                        icon.classList.remove('fa-eye');
                                        icon.classList.add('fa-eye-slash');
                                    } else {
                                        password.type = 'password';
                                        icon.classList.remove('fa-eye-slash');
                                        icon.classList.add('fa-eye');
                                    }
                                });
                            </script>
                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-sm">
                                Login <i class="fas fa-sign-in-alt ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="<?php echo ROOT; ?>/" class="text-muted text-decoration-none small"><i class="fas fa-arrow-left me-1"></i> Back to Website</a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>
