<?php include 'layout/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 fade-in-up">
                    <h1 class="hero-title">Empowering Every Child to <span>Learn Differently</span></h1>
                    <p class="lead mb-4 text-muted">Professional psycho-educational assessments for children and young
                        adults with dyslexia, ADHD, autism spectrum disorders, and other learning challenges. Based in
                        Weija, Accra, serving families across Ghana.</p>
                    <div class="d-flex gap-3">
                        <a href="https://calendar.app.google/oNQgmMUEVmvg8HA69" target="_blank" class="btn btn-book">Book Appointment</a>
                        <a href="<?php echo ROOT; ?>/services" class="btn btn-outline-primary px-4 py-2 rounded-pill">Our Services</a>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0 fade-in-up delay-2">
                    <div class="position-relative">
                        <img src="<?php echo ROOT; ?>/assets/img/Cld Pic2.jpeg" alt="Children Learning Group"
                            class="img-fluid img-fluid-rounded">
                        <div
                            class="position-absolute bottom-0 start-0 bg-white p-3 shadow rounded-3 m-3 d-none d-md-block">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-success rounded-circle p-2 text-white"><i class="fas fa-heart"></i></div>
                                <div>
                                    <small class="d-block fw-bold">Serving Families Since</small>
                                    <span class="text-primary fw-bold">2015</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Assessment CTAs -->
    <section class="py-5 text-center bg-white">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-center gap-3 align-items-center">
                <a href="<?php echo ROOT; ?>/tests" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow-lg">
                    <i class="fas fa-laptop-code me-2"></i> Online Assessment
                </a>
                <a href="https://calendar.app.google/oNQgmMUEVmvg8HA69" target="_blank" class="btn btn-outline-primary btn-lg rounded-pill px-5 fw-bold border-2">
                    <i class="fas fa-user-check me-2"></i> In-Person Assessment
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-white">
        <div class="container text-center">
            <h2 class="section-title">Understanding Your Child's Unique Learning Journey</h2>
            <p class="text-muted mb-5 mx-auto" style="max-width: 700px;">At the Center for Learning Disabilities
                (CLD), we believe every child deserves the opportunity to learn in a way that works for
                them.</p>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card h-100 animate-card p-4">
                        <div class="text-primary mb-3"><i class="fas fa-user-md fa-2x"></i></div>
                        <h5>Expert Assessment</h5>
                        <p class="small text-muted">Comprehensive psycho-educational evaluations by qualified
                            professionals.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 animate-card p-4">
                        <div class="text-primary mb-3"><i class="fas fa-hand-holding-heart fa-2x"></i></div>
                        <h5>Compassionate Care</h5>
                        <p class="small text-muted">Empathetic approach that prioritizes each child's unique needs and
                            wellbeing.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 animate-card p-4">
                        <div class="text-primary mb-3"><i class="fas fa-users fa-2x"></i></div>
                        <h5>Family Support</h5>
                        <p class="small text-muted">We guide families through every step with clear communication and
                            resources.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 animate-card p-4">
                        <div class="text-primary mb-3"><i class="fas fa-award fa-2x"></i></div>
                        <h5>Proven Results</h5>
                        <p class="small text-muted">Evidence-based strategies that help children unlock their full
                            potential.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 text-center text-white"
        style="background: linear-gradient(rgba(0,123,255,0.9), rgba(0,123,255,0.9)), url('https://via.placeholder.com/1200x400'); background-size: cover; background-attachment: fixed;">
        <div class="container py-4">
            <h2 class="display-5 fw-bold mb-3">Ready to Support Your Child's Learning Journey?</h2>
            <p class="lead mb-4">Book an appointment with us today.</p>
            <a href="https://calendar.app.google/oNQgmMUEVmvg8HA69" target="_blank" class="btn btn-light btn-lg rounded-pill px-5 text-primary fw-bold">Schedule a
                Consultation <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
    </section>

<?php include 'layout/footer.php'; ?>
