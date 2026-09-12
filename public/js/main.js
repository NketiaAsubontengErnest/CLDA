document.addEventListener('DOMContentLoaded', () => {
    const observerOptions = {
        threshold: 0.15,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    const elementsToAnimate = document.querySelectorAll('.animate-card, .fade-in-up, .testimonial-card');

    elementsToAnimate.forEach(el => {
        observer.observe(el);
    });

    elementsToAnimate.forEach(el => {
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight) {
            el.classList.add('visible');
        }
    });

    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const formResponse = document.getElementById('formResponse');
            const originalBtnContent = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';

            const formData = new FormData(contactForm);

            try {
                const response = await fetch(`${ROOT}/contact/process`, {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    let errorMessage = `Server error: ${response.status}`;

                    try {
                        const errorJson = JSON.parse(errorText);
                        errorMessage = errorJson.message || errorMessage;
                    } catch (parseError) {
                        if (errorText.includes('500 Internal Server Error')) {
                            errorMessage = "Server error 500: The mail server might not be configured correctly.";
                        } else {
                            errorMessage = "The server returned an invalid response. Please check your PHP configuration.";
                        }
                    }
                    throw new Error(errorMessage);
                }

                const result = await response.json();

                formResponse.style.display = 'block';
                if (result.status === 'success') {
                    formResponse.className = 'alert alert-success alert-dismissible fade show rounded-3 small';
                    formResponse.innerHTML = `<strong>Success!</strong> ${result.message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
                    contactForm.reset();
                } else {
                    formResponse.className = 'alert alert-danger alert-dismissible fade show rounded-3 small';
                    formResponse.innerHTML = `<strong>Error!</strong> ${result.message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
                }
            } catch (error) {
                console.error("Form submission error:", error);
                formResponse.style.display = 'block';
                formResponse.className = 'alert alert-danger alert-dismissible fade show rounded-3 small';
                formResponse.innerHTML = `<strong>Error!</strong> ${error.message || 'Something went wrong. Please try again later.'}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnContent;
            }
        });
    }

    // Handle Drag and Drop Uploads
    const uploadArea = document.querySelector('.upload-area');
    if (uploadArea) {
        const fileInput = uploadArea.querySelector('input[type="file"]');
        const filePreview = document.querySelector('.file-preview');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
            }, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, () => uploadArea.classList.add('active'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, () => uploadArea.classList.remove('active'), false);
        });

        uploadArea.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            updateFilePreview(files[0]);
        }, false);

        fileInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                updateFilePreview(this.files[0]);
            }
        });

        function updateFilePreview(file) {
            if (filePreview && file) {
                filePreview.style.display = 'block';
                filePreview.innerHTML = `<i class="fas fa-file-alt me-2"></i> Selected: <strong>${file.name}</strong> (${(file.size / 1024).toFixed(1)} KB)`;

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const existingImg = filePreview.querySelector('img');
                        if (existingImg) existingImg.remove();
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '60px';
                        img.style.height = '60px';
                        img.style.objectFit = 'cover';
                        img.style.borderRadius = '8px';
                        img.style.marginTop = '10px';
                        img.style.display = 'block';
                        filePreview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            }
        }
    }
});
