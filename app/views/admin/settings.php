<?php require_once '../app/views/layout/header.php'; ?>

<main class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold text-dark">Payment Settings</h2>
                <p class="text-muted mb-0">Configure your Paystack API keys.</p>
            </div>
            <a href="<?php echo ROOT; ?>/admin" class="btn btn-outline-secondary px-4 rounded-pill fw-bold">
                <i class="fas fa-arrow-left me-2"></i> Dashboard
            </a>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success rounded-3 mb-4">Settings updated successfully.</div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-5">
                        <form action="" method="POST">
                            <input type="hidden" name="update_settings" value="1">
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Paystack Public Key</label>
                                <input type="text" name="paystack_public_key" class="form-control" value="<?php echo htmlspecialchars($settings['paystack_public_key'] ?? ''); ?>" placeholder="pk_test_..." required>
                                <div class="form-text">Found in your Paystack Dashboard > Settings > API Keys.</div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Paystack Secret Key</label>
                                <div class="input-group">
                                    <input type="password" name="paystack_secret_key" id="secret_key" class="form-control" value="<?php echo htmlspecialchars($settings['paystack_secret_key'] ?? ''); ?>" placeholder="sk_test_..." required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleSecretKey">
                                        <i class="fas fa-eye" id="secretIcon"></i>
                                    </button>
                                </div>
                                <div class="form-text">Keep this key secret. It is used to verify transactions.</div>
                            </div>

                            <script>
                                document.getElementById('toggleSecretKey').addEventListener('click', function() {
                                    const input = document.getElementById('secret_key');
                                    const icon = document.getElementById('secretIcon');
                                    if (input.type === 'password') {
                                        input.type = 'text';
                                        icon.classList.remove('fa-eye');
                                        icon.classList.add('fa-eye-slash');
                                    } else {
                                        input.type = 'password';
                                        icon.classList.remove('fa-eye-slash');
                                        icon.classList.add('fa-eye');
                                    }
                                });
                            </script>
                            
                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold">
                                Save Settings
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>
