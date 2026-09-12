<?php include dirname(__DIR__) . '/layout/header.php'; ?>

<header class="py-5 bg-light text-center" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('<?php echo ROOT; ?>/public/assets/img/team_1.jpg') no-repeat center center; background-size: cover; color: white;">
    <div class="container py-5">
        <h1 class="display-3 fw-bold text-white">Legislative <span class="text-white">Agenda</span></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>/" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item text-white-50">Advocacy</li>
                <li class="breadcrumb-item active text-white" aria-current="page">Legislative Agenda</li>
            </ol>
        </nav>
    </div>
</header>

<section class="py-5">
    <div class="container">
        <div class="row mb-5 animate-card">
            <div class="col-lg-12 text-center">
                <div class="p-5 bg-white shadow-sm rounded-4">
                    <p class="lead mb-4">The Center for Learning Disabilities (CLD) calls on the government to provide a legislative Act to protect students with learning disabilities and its related disorders.</p>
                    <div class="alert alert-warning border-0 rounded-4 p-4 text-start">
                        <p class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i> The Disability Act, 2006 (Act 715) has little or no legislative backing for students with learning disabilities. The provision focuses on persons with Physical Impaired, Visually Impaired, and persons with long term Health Impaired.</p>
                    </div>
                    <h3 class="mt-5 text-primary">Persons with learning disabilities are entitled to their rights and the services they need.</h3>
                </div>
            </div>
        </div>

        <div class="row mt-5 animate-card">
            <div class="col-12">
                <h2 class="h3 mb-4 text-primary text-center">Our Legislative Agenda Focus on Ensuring That:</h2>
                <div class="row g-4 mt-2">
                    <?php 
                    $agendas = [
                        "Our leaders must implement a legislative instrument such the Individual with Disability Education Act to help students with learning disabilities.",
                        "There must be a clear and specific steps to help children and young adult with learning disabilities.",
                        "The government and it’s agencies must demonstrate enough commitment to support and protect students with learning disabilities.",
                        "Government must provide adequate funding to support student with learning disabilities."
                    ];
                    foreach($agendas as $index => $agenda): ?>
                    <div class="col-md-6">
                        <div class="p-4 bg-light rounded-4 h-100 d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle me-3 flex-shrink-0" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; font-weight: bold;"><?php echo $index + 1; ?></div>
                            <p class="mb-0 fw-bold"><?php echo $agenda; ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include dirname(__DIR__) . '/layout/footer.php'; ?>
