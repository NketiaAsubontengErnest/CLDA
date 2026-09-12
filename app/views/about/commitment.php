<?php include dirname(__DIR__) . '/layout/header.php'; ?>

<header class="py-5 bg-light text-center" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('<?php echo ROOT; ?>/public/assets/img/about_mission_png_1770983777939.jpg') no-repeat center center; background-size: cover; color: white;">
    <div class="container py-5">
        <h1 class="display-3 fw-bold text-white">Our <span class="text-white">Commitment</span></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>/" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item text-white-50">About</li>
                <li class="breadcrumb-item active text-white" aria-current="page">Our Commitment</li>
            </ol>
        </nav>
    </div>
</header>

<section class="py-5">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8 animate-card">
                <div class="p-5 bg-white shadow-sm rounded-4 border-top border-primary border-4">
                    <div class="text-primary mb-4"><i class="fas fa-handshake fa-4x"></i></div>
                    <p class="lead mb-4">The Center is committed to ensuring that all student information is treated with the highest level of confidentiality, in accordance with legal requirements.</p>
                    <p class="mb-4 text-muted">We pledge to provide equitable assessment and evaluation for students with learning disabilities by supporting, empowering, and instilling hope in their academic and social journey. In partnership with schools, parents, caregivers, and students, we work to identify and address each learner’s unique needs, ensuring they receive the resources and opportunities necessary to thrive.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include dirname(__DIR__) . '/layout/footer.php'; ?>
