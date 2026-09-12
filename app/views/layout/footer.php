    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3">
                    <p class="small text-muted">Empowering Every Child to Learn Differently</p>
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/CLDAGhana" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://cldaghana.wordpress.com/gifted-children/?share=twitter&nb=1" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://wa.me/message/BVJNXBOO23LWL1" target="_blank"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-3">
                    <h6 class="text-white mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo ROOT; ?>/">Home</a></li>
                        <li><a href="<?php echo ROOT; ?>/about">About Us</a></li>
                        <li><a href="<?php echo ROOT; ?>/services">Services</a></li>
                        <li><a href="<?php echo ROOT; ?>/resources">Resources</a></li>
                        <li><a href="<?php echo ROOT; ?>/contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="text-white mb-3">Our Services</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo ROOT; ?>/understand/dyslexia">Specific Learning Disabilities</a></li>
                        <li><a href="<?php echo ROOT; ?>/understand/adhd">ADHD Assessment</a></li>
                        <li><a href="<?php echo ROOT; ?>/understand/autism">Autism Assessment</a></li>
                        <li><a href="<?php echo ROOT; ?>/understand/delays">Developmental Delays</a></li>
                        <li><a href="<?php echo ROOT; ?>/tests">Online Tests</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="text-white mb-3">Contact Us</h6>
                    <ul class="list-unstyled small text-muted">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i> First Floor Weija SCC Snnit-Block A3, New Weija Accra Ghana</li>
                        <li class="mb-2"><i class="fas fa-phone me-2 text-primary"></i> 0537021064, 0204101335 <a href="https://wa.me/message/BVJNXBOO23LWL1" target="_blank" class="ms-2 text-success"><i class="fab fa-whatsapp"></i></a></li>
                        <li class="mb-2"><i class="fas fa-envelope me-2 text-primary"></i> cldaghana@gmail.com<br><span class="ms-4">info@cldghana.com</span></li>
                    </ul>
                </div>
            </div>
            <hr class="mt-5 border-secondary">
            <p class="text-center small text-muted mb-0">
                © <?php echo date('Y'); ?> Center for Learning Disabilities. All rights reserved. | 
                <a href="<?php echo ROOT; ?>/admin/login" class="text-muted text-decoration-none"><i class="fas fa-lock me-1"></i>Administrator</a>
            </p>
        </div>
    </footer>

    <!-- Universal File Preview Modal -->
    <div class="modal fade" id="universalPreviewModal" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" style="height: 90vh;">
            <div class="modal-content h-100 border-0 rounded-4 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="universalPreviewTitle">File Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 h-100 pt-3 bg-light d-flex align-items-center justify-content-center" id="universalPreviewBody">
                    <!-- Content will be injected here -->
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <a href="#" id="universalDownloadLink" class="btn btn-primary rounded-pill px-4" download>
                        <i class="fas fa-download me-2"></i> Download File
                    </a>
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom JS -->
    <script src="<?php echo ROOT; ?>/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function previewFile(url, title = 'File Preview') {
            document.getElementById('universalPreviewTitle').innerText = title;
            const downloadLink = document.getElementById('universalDownloadLink');
            const previewBody = document.getElementById('universalPreviewBody');
            
            downloadLink.href = url;
            
            // Determine file type based on extension
            const extension = url.split('.').pop().toLowerCase();
            let content = '';
            
            if (['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'].includes(extension)) {
                content = `<img src="${url}" class="img-fluid" style="max-height: 100%; max-width: 100%; object-fit: contain;">`;
            } else if (['pdf'].includes(extension)) {
                content = `<iframe src="${url}" style="width: 100%; height: 100%; border: none;"></iframe>`;
            } else if (['mp4', 'webm', 'ogg'].includes(extension)) {
                content = `<video controls style="max-width: 100%; max-height: 100%;"><source src="${url}" type="video/${extension}">Your browser does not support the video tag.</video>`;
            } else if (['mp3', 'wav'].includes(extension)) {
                content = `<div class="p-5 text-center"><i class="fas fa-music fa-5x text-primary mb-4"></i><br><audio controls><source src="${url}" type="audio/${extension}">Your browser does not support the audio element.</audio></div>`;
            } else {
                // Fallback for non-previewable files (doc, docx, zip, etc)
                content = `
                    <div class="text-center p-5">
                        <i class="fas fa-file-alt fa-5x text-secondary mb-4"></i>
                        <h5>Preview not available</h5>
                        <p class="text-muted">This file type (${extension}) cannot be previewed directly in the browser.</p>
                        <a href="${url}" class="btn btn-primary rounded-pill mt-3" download>Download to View</a>
                    </div>
                `;
            }
            
            previewBody.innerHTML = content;
            
            var modal = new bootstrap.Modal(document.getElementById('universalPreviewModal'));
            modal.show();
        }

        // Clean up on close
        document.getElementById('universalPreviewModal').addEventListener('hidden.bs.modal', function () {
            document.getElementById('universalPreviewBody').innerHTML = '';
        });
    </script>
</body>

</html>
