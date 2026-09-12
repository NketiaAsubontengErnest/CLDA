<?php include dirname(__DIR__) . '/layout/header.php'; ?>

<header class="py-5 bg-light text-center" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('<?php echo ROOT; ?>/public/assets/img/hero_children_learning_png_1770984020174.jpg') no-repeat center center; background-size: cover; color: white;">
    <div class="container py-5">
        <h1 class="display-3 fw-bold text-white">Understanding <span class="text-white">Dysgraphia</span></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>/" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item text-white-50">Understand</li>
                <li class="breadcrumb-item active text-white" aria-current="page">Dysgraphia</li>
            </ol>
        </nav>
    </div>
</header>

<section class="py-5">
    <div class="container">
        <!-- Intro Section -->
        <div class="row mb-5 animate-card">
            <div class="col-lg-12">
                <div class="p-5 bg-white shadow-sm rounded-4 border-start border-primary border-4">
                    <p class="lead mb-4">Dysgraphia is a condition that causes trouble with written expression. Writing difficulties are common among children and can stem from a variety of learning and attention issues.</p>
                    <p class="text-muted mb-0">There’s no cure or easy fix for dysgraphia. But there are strategies and therapies that can help a child improve his writing. This will help him thrive in school and anywhere else expressing himself in writing is important.</p>
                </div>
            </div>
        </div>

        <!-- What is Dysgraphia -->
        <div class="row mb-5 animate-card">
            <div class="col-12">
                <div class="p-4 p-md-5 bg-white shadow-sm rounded-4">
                    <h2 class="h3 text-primary mb-4"><i class="fas fa-pen-nib me-2"></i> What is Dysgraphia?</h2>
                    <div class="row">
                        <div class="col-lg-8">
                            <p>The term comes from the Greek words <strong>dys</strong> (“impaired”) and <strong>graphia</strong> (“making letter forms by hand”). Dysgraphia is a brain-based issue. It’s not the result of a child being lazy.</p>
                            <p>For many children with dysgraphia, just holding a pencil and organizing letters on a line is difficult. Their handwriting tends to be messy. Many struggle with spelling and putting thoughts on paper. Tasks like putting ideas into language that is organized, stored and then retrieved from memory may all add to struggles with written expression.</p>
                            
                            <div class="bg-light p-4 rounded-4 mb-4">
                                <h5 class="fw-bold"><i class="fas fa-info-circle text-primary me-2"></i> Diagnostic Terms</h5>
                                <p class="small mb-0">The DSM-5 uses the phrase <strong>“an impairment in written expression”</strong> under the section of “specific learning disorder.” This is the term used by most doctors and psychologists. IDEA describes it under the section of <strong>“specific learning disability.”</strong></p>
                            </div>

                            <p>Whatever definition is used, slow or sloppy writing isn’t necessarily a sign that your child isn’t trying hard enough. Writing requires a complex set of fine motor and language processing skills. For kids with dysgraphia, the writing process is harder and slower.</p>
                        </div>
                        <div class="col-lg-4">
                            <div class="p-4 bg-primary text-white rounded-4 shadow-sm h-100">
                                <h5 class="fw-bold mb-3">Core Challenges:</h5>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-3 d-flex align-items-start"><i class="fas fa-hand-paper me-2 mt-1"></i> Fine motor skills & grip</li>
                                    <li class="mb-3 d-flex align-items-start"><i class="fas fa-spell-check me-2 mt-1"></i> Spelling & legible formation</li>
                                    <li class="mb-3 d-flex align-items-start"><i class="fas fa-brain me-2 mt-1"></i> Organizing thoughts</li>
                                    <li class="d-flex align-items-start"><i class="fas fa-save me-2 mt-1"></i> Memory retrieval for writing</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Symptoms Sections -->
        <div class="row mb-5 animate-card">
            <div class="col-12">
                <h2 class="h3 text-primary mb-4 text-center">Symptoms of Dysgraphia</h2>
                <div class="row g-4">
                    <?php
                    $symptom_cats = [
                        "Visual-Spatial" => [
                            "icon" => "fa-arrows-alt",
                            "items" => ["Trouble with shape-discrimination and letter spacing", "Letters go in all directions/run together", "Hard time writing on a line or inside margins"]
                        ],
                        "Fine Motor" => [
                            "icon" => "fa-hand-pointer",
                            "items" => ["Trouble holding pencil correctly", "Struggles with tracing, cutting, or tying shoes", "Awkward body/paper position when writing"]
                        ],
                        "Language Processing" => [
                            "icon" => "fa-comment-dots",
                            "items" => ["Trouble getting ideas down quickly", "Loses train of thought easily", "Hard time following complex directions"]
                        ],
                        "Spelling & Handwriting" => [
                            "icon" => "fa-signature",
                            "items" => ["Mixes upper and lowercase letters", "Blends printing and cursive", "Hand gets tired or cramped quickly"]
                        ],
                        "Grammar & Usage" => [
                            "icon" => "fa-paragraph",
                            "items" => ["Doesn't start sentences with capital letters", "Overuses commas or mixes verb tenses", "Writes in endless 'run-on' sentences"]
                        ],
                        "Organization" => [
                            "icon" => "fa-sitemap",
                            "items" => ["Trouble telling a story in order", "Leaves out important facts or details", "Better at conveying ideas when speaking"]
                        ]
                    ];
                    foreach($symptom_cats as $title => $data): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="p-4 bg-white shadow-sm rounded-4 h-100 border-bottom border-primary border-3">
                            <h5 class="fw-bold mb-3"><i class="fas <?php echo $data['icon']; ?> text-primary me-2"></i> <?php echo $title; ?></h5>
                            <ul class="small list-unstyled mb-0 text-muted">
                                <?php foreach($data['items'] as $item): ?>
                                <li class="mb-2 d-flex"><i class="fas fa-check text-primary me-2 mt-1"></i> <?php echo $item; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Signs by Age -->
        <div class="row mb-5 animate-card">
            <div class="col-12 text-center mb-4">
                <h2 class="h3 text-primary">Signs by Age Group</h2>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4 bg-light rounded-4 h-100">
                    <h5 class="fw-bold text-primary">Preschool</h5>
                    <p class="small text-muted mb-0">Hesitant to write and draw; says they hate coloring or avoids fine motor activities.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4 bg-light rounded-4 h-100">
                    <h5 class="fw-bold text-primary">School-Age</h5>
                    <p class="small text-muted mb-0">Illegible handwriting (mix of cursive/print); uneven letter size; may need to say words out loud while writing.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4 bg-light rounded-4 h-100">
                    <h5 class="fw-bold text-primary">Teenagers</h5>
                    <p class="small text-muted mb-0">Writes in very simple sentences; significantly more grammatical mistakes than peers their age.</p>
                </div>
            </div>
        </div>

        <!-- Causes & Support -->
        <div class="row g-5 animate-card mb-5">
            <div class="col-md-7">
                <div class="p-4 p-md-5 bg-white shadow-sm rounded-4 h-100">
                    <h2 class="h3 text-primary mb-4">Possible Causes</h2>
                    <p>Experts believe dysgraphia involves issues in step(s) of the writing process: <strong>organizing information</strong> in memory and/or <strong>physically getting words onto paper</strong>.</p>
                    <div class="mb-3">
                        <h6 class="fw-bold">Orthographic Coding:</h6>
                        <p class="small text-muted">A difficulty in the working memory's ability to store unfamiliar written words, making it hard to remember how to form a letter or word.</p>
                    </div>
                    <div class="alert alert-secondary border-0 rounded-4">
                        <p class="small mb-0"><strong>Note:</strong> It is often mistaken for laziness because the written product doesn't reflect what the child actually knows.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="p-4 p-md-5 bg-primary text-white rounded-4 h-100 shadow">
                    <h2 class="h3 mb-4">What to do at Home</h2>
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex align-items-start">
                            <i class="fas fa-clipboard-list me-3 mt-1"></i>
                            <div class="small"><strong>Observe & Note:</strong> Track patterns and triggers to help doctors and teachers.</div>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="fas fa-hand-sparkles me-3 mt-1"></i>
                            <div class="small"><strong>Warm-up Exercises:</strong> Hand shaking or rubbing to relieve tension before writing.</div>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="fas fa-puzzle-piece me-3 mt-1"></i>
                            <div class="small"><strong>Motor Skill Games:</strong> Use clay or squeeze balls to strengthen hand muscles.</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Related Conditions -->
        <div class="row animate-card">
            <div class="col-12">
                <h2 class="h3 text-primary mb-4 text-center">Related Conditions</h2>
                <div class="row g-3">
                    <?php
                    $related = [
                        "Dyslexia" => "Challenges with reading and spelling often overlap with writing issues.",
                        "ADHD" => "Attention and impulsivity issues can significantly impact the writing process.",
                        "Language Disorders" => "Difficulty using correct grammar or putting thoughts into words.",
                        "Dyspraxia" => "Poor physical coordination affects the fine motor task of printing."
                    ];
                    foreach($related as $title => $desc): ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="p-3 bg-light rounded-4 h-100 text-center">
                            <h6 class="fw-bold mb-2"><?php echo $title; ?></h6>
                            <p class="extra-small text-muted mb-0"><?php echo $desc; ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-5 text-center">
                    <p class="small text-muted">Source: NCLD, Understood</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include dirname(__DIR__) . '/layout/footer.php'; ?>
