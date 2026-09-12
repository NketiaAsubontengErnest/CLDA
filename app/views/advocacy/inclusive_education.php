<?php include dirname(__DIR__) . '/layout/header.php'; ?>

<header class="py-5 bg-light text-center" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('<?php echo ROOT; ?>/public/assets/img/ourservies.jpg') no-repeat center center; background-size: cover; color: white;">
    <div class="container py-5">
        <h1 class="display-3 fw-bold text-white">Inclusive <span class="text-white">Education</span></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>/" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item text-white-50">Advocacy</li>
                <li class="breadcrumb-item active text-white" aria-current="page">Inclusive Education</li>
            </ol>
        </nav>
    </div>
</header>

<section class="py-5">
    <div class="container">
        <div class="row align-items-center mb-5 animate-card">
            <div class="col-lg-12">
                <div class="p-5 bg-white shadow-sm rounded-4">
                    <p class="lead">CLD advocates for transformation in Ghana’s special education system. We call for a system which accommodate all students irrespective of their disability in our regular/mainstream education system.</p>
                    <p>The overwhelming majority of students with learning disabilities attend public schools and some marginal number in private schools. More than half of all public school students are from low income families.</p>
                    <div class="alert alert-primary border-0 rounded-4 p-4 mt-4">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-chart-line me-2"></i> Today, 1 in every 5 school going children have some form of learning disabilities, attention deficit and other related disorder.</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5 animate-card">
            <div class="col-12">
                <h2 class="h3 mb-4 text-primary">CLD calls on the government to:</h2>
                <div class="row g-4">
                    <?php 
                    $calls = [
                        "To provide a comprehensive public school system to support at risk students. The unsatisfactory rate and achievement gaps remain high for these groups of undeserved students, examples is poor performance of students in the WASSCE and BECE result.",
                        "To implement evidence-based teaching practices to support at risk student in the general classroom.",
                        "To stop diversion of resources from the education system.",
                        "Regular schools must be more inclusive to accommodate at risk students.",
                        "To sanction educational institutions who refuses to admit student with any form of disabilities.",
                        "The Ministry of Education must take a deep look at the nation’s admission criteria.",
                        "The inclusive education policy must be a corner stone to support students with learning disabilities in the general classroom.",
                        "The Gender and Social Protection ministry must provide a care system to ensure students with learning disabilities are not left behind."
                    ];
                    foreach($calls as $index => $call): ?>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start p-3 bg-white shadow-sm rounded-4 h-100 border-start border-primary border-3">
                            <span class="badge bg-primary rounded-circle me-3 mt-1" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;"><?php echo $index + 1; ?></span>
                            <p class="mb-0 small"><?php echo $call; ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include dirname(__DIR__) . '/layout/footer.php'; ?>
