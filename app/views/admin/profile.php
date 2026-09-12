<?php require_once '../app/views/layout/header.php'; ?>

<main class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold text-dark">Profile Settings</h2>
                <p class="text-muted mb-0">Update your username and password.</p>
            </div>
            <a href="<?php echo ROOT; ?>/admin" class="btn btn-outline-secondary px-4 rounded-pill fw-bold">
                <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-5">
                        <?php if (isset($message['error'])): ?>
                            <div class="alert alert-danger rounded-3 mb-4">
                                <?php echo $message['error']; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($message['success'])): ?>
                            <div class="alert alert-success rounded-3 mb-4">
                                <?php echo $message['success']; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Current Username</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">New Username</label>
                                <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">New Password (leave blank to keep current)</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="new_password" class="form-control" placeholder="New Password">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password', 'new_password_icon')">
                                        <i class="fas fa-eye" id="new_password_icon"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold">Current Password (Required to save changes)</label>
                                <div class="input-group">
                                    <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Current Password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password', 'current_password_icon')">
                                        <i class="fas fa-eye" id="current_password_icon"></i>
                                    </button>
                                </div>
                            </div>

                            <script>
                                function togglePassword(inputId, iconId) {
                                    const input = document.getElementById(inputId);
                                    const icon = document.getElementById(iconId);
                                    if (input.type === 'password') {
                                        input.type = 'text';
                                        icon.classList.remove('fa-eye');
                                        icon.classList.add('fa-eye-slash');
                                    } else {
                                        input.type = 'password';
                                        icon.classList.remove('fa-eye-slash');
                                        icon.classList.add('fa-eye');
                                    }
                                }
                            </script>

                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold">
                                Save Changes
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>
