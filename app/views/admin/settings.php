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
                            
                            <hr class="my-4">
                            <h5 class="fw-bold mb-1">Receipt Delivery</h5>
                            <p class="text-muted small mb-3">Used to send payment receipts to clients by SMS (Arkesel) and email. Leave a secret field blank to keep the saved value.</p>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">SMS API Key (Arkesel)</label>
                                    <input type="password" name="sms_api_key" class="form-control" autocomplete="new-password" placeholder="<?php echo !empty($settings['sms_api_key']) ? '•••••• saved' : 'Enter API key'; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">SMS Sender ID</label>
                                    <input type="text" name="sms_sender_id" maxlength="11" class="form-control" value="<?php echo htmlspecialchars($settings['sms_sender_id'] ?? ''); ?>" placeholder="CLD">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Email SMTP Host</label>
                                    <input type="text" name="smtp_host" class="form-control" value="<?php echo htmlspecialchars($settings['smtp_host'] ?? 'smtp.gmail.com'); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">SMTP Port</label>
                                    <input type="number" name="smtp_port" class="form-control" value="<?php echo htmlspecialchars($settings['smtp_port'] ?? '587'); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Email Username</label>
                                    <input type="text" name="smtp_username" class="form-control" value="<?php echo htmlspecialchars($settings['smtp_username'] ?? ''); ?>" placeholder="info@cldghana.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Email Password / App Password</label>
                                    <input type="password" name="smtp_password" class="form-control" autocomplete="new-password" placeholder="<?php echo !empty($settings['smtp_password']) ? '•••••• saved' : 'Enter password'; ?>">
                                </div>
                            </div>

                            <div class="alert alert-light border small">
                                <strong>Paystack webhook URL:</strong> <code><?php echo ROOT; ?>/api/webhooks/payment</code><br>
                                Add it in Paystack Dashboard &rarr; Settings &rarr; API Keys &amp; Webhooks.
                            </div>

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
