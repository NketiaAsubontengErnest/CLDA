<?php include 'layout/header.php'; ?>

    <!-- Page Header -->
    <!-- Page Header -->
    <header class="py-5 bg-light text-center" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('<?php echo ROOT; ?>/public/assets/img/about_mission_png_1770983926347.jpg') no-repeat center center; background-size: cover; color: white;">
        <div class="container py-5">
            <h1 class="display-3 fw-bold text-white">Get in <span class="text-white">Touch</span></h1>
            <p class="lead text-white-50 mx-auto" style="max-width: 800px;">Ready to take the first step? Schedule an assessment directly or contact us with any questions. We're here to help your child thrive.</p>
            <a href="https://calendar.app.google/oNQgmMUEVmvg8HA69" target="_blank" class="btn btn-book mt-3">Book Consultation</a>
        </div>
    </header>

    <!-- Contact Form & Info -->
    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                <!-- Form -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm p-4 p-md-5 rounded-4 animate-card">
                        <h4 class="mb-4">Send Us a Message</h4>
                        <form id="contactForm">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="John Mensah" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold">Email Address</label>
                                    <input type="email" name="email" class="form-control" placeholder="john@example.com"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold">Phone Number</label>
                                    <input type="tel" name="phone" class="form-control" placeholder="+233 20 123 4567"
                                        required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold">Message</label>
                                <textarea name="message" class="form-control" rows="5"
                                    placeholder="Tell us about your child's needs and any concerns you have..."
                                    required></textarea>
                            </div>
                            <div id="formResponse" class="mb-3" style="display: none;"></div>
                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold"
                                id="submitBtn">
                                <span>Send Message</span>
                                <i class="fas fa-paper-plane ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <!-- Info -->
                <div class="col-lg-5">
                    <h4 class="mb-4">Contact Information</h4>
                    <p class="text-muted mb-5">We're located in Weija, Accra, and serve families throughout Ghana. Reach
                        out via phone, email, or visit us at our office.</p>

                    <div class="d-flex gap-4 mb-4">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-primary h-100"><i
                                class="fas fa-map-marker-alt fa-lg"></i></div>
                        <div>
                            <h6>Office Address</h6>
                            <p class="small text-muted">First Floor Weija SCC Snnit-Block A3, New Weija Accra Ghana</p>
                        </div>
                    </div>
                    <div class="d-flex gap-4 mb-4">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-primary h-100"><i
                                class="fas fa-phone fa-lg"></i></div>
                        <div>
                            <h6>Phone</h6>
                            <p class="small text-muted">0537021064, 0204101335<br>
                            <a href="https://wa.me/message/BVJNXBOO23LWL1" target="_blank" class="text-success text-decoration-none"><i class="fab fa-whatsapp me-1"></i> Message us on WhatsApp</a>
                            <br>Monday - Friday, 9am - 5pm</p>
                        </div>
                    </div>
                    <div class="d-flex gap-4 mb-4">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-primary h-100"><i
                                class="fas fa-envelope fa-lg"></i></div>
                        <div>
                            <h6>Email</h6>
                            <p class="small text-muted">cldaghana@gmail.com<br>info@cldghana.com<br>We respond within 24 hours</p>
                        </div>
                    </div>
                    <div class="d-flex gap-4">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-primary h-100"><i
                                class="fas fa-clock fa-lg"></i></div>
                        <div>
                            <h6>Office Hours</h6>
                            <p class="small text-muted">Monday - Friday: 9:00 AM - 5:00 PM<br>Saturday: 10:00 AM - 2:00
                                PM<br>Sunday: Closed</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="section-title">Find Us</h2>
            <p class="text-muted mb-5">Conveniently located in Weija, Accra, with easy access from all parts of the city
            </p>
            <div class="rounded-4 overflow-hidden shadow-sm"
                style="height: 400px; position: relative;">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3971.0182650893!2d-0.34279549999999997!3d5.554636349999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNcKwMzMnMTYuNyJOIDDCsDIwJzI2LjIiVw!5e0!3m2!1sen!2sgh!4v1708179200000!5m2!1sen!2sgh" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

<?php include 'layout/footer.php'; ?>
