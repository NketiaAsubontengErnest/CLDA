<?php $active_page = $active_page ?? ''; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $page_description ?? 'Center for Learning Disabilities - Assessment Center'; ?>">
    <title>Center for Learning Disabilities - Assessment Center</title>
    <link rel="icon" type="image/png" href="<?php echo ROOT; ?>/assets/img/logo.png">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo ROOT; ?>/css/style.css?v=<?php echo time(); ?>">
    <style>
        /* Fail-safe styles for the Book Now button */
        .btn-book {
            background-color: #28a745 !important;
            color: #fff !important;
            border-radius: 50px !important;
            padding: 10px 30px !important;
            font-weight: 700 !important;
            font-size: 15px !important;
            border: none !important;
            outline: none !important;
            cursor: pointer !important;
            display: inline-block !important;
            text-decoration: none !important;
            appearance: none !important;
            -webkit-appearance: none !important;
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.2) !important;
        }
        .btn-book.active {
            background-color: #006aff !important; /* Blue when active */
            box-shadow: 0 4px 10px rgba(0, 106, 255, 0.2) !important;
        }
    </style>
    <script>const ROOT = '<?php echo ROOT; ?>';</script>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo ROOT; ?>/">
                <img src="<?php echo ROOT; ?>/assets/img/logo.png" alt="CLD Logo" height="45">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link <?php echo ($active_page == 'home') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/">Home</a></li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo ($active_page == 'about') ? 'active' : ''; ?>" href="#" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            About
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="aboutDropdown">
                            <li><a class="dropdown-item <?php echo ($_SERVER['REQUEST_URI'] == ROOT.'/about/background') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/about/background">Background</a></li>
                            <li><a class="dropdown-item <?php echo ($_SERVER['REQUEST_URI'] == ROOT.'/about/mission') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/about/mission">Mission and Vision</a></li>
                            <li><a class="dropdown-item <?php echo ($_SERVER['REQUEST_URI'] == ROOT.'/about/commitment') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/about/commitment">Our Commitment</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo ($active_page == 'understand') ? 'active' : ''; ?>" href="#" id="understandDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Understand
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="understandDropdown">
                            <li><a class="dropdown-item <?php echo ($_SERVER['REQUEST_URI'] == ROOT.'/understand/dyslexia') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/understand/dyslexia">Dyslexia</a></li>
                            <li><a class="dropdown-item <?php echo ($_SERVER['REQUEST_URI'] == ROOT.'/understand/dysgraphia') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/understand/dysgraphia">Dysgraphia</a></li>
                            <li><a class="dropdown-item <?php echo ($_SERVER['REQUEST_URI'] == ROOT.'/understand/dyscalculia') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/understand/dyscalculia">Dyscalculia</a></li>
                            <li><a class="dropdown-item <?php echo ($_SERVER['REQUEST_URI'] == ROOT.'/understand/dyspraxia') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/understand/dyspraxia">Dyspraxia</a></li>
                            <li><a class="dropdown-item <?php echo ($_SERVER['REQUEST_URI'] == ROOT.'/understand/adhd') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/understand/adhd">Attention Deficit Hyperactivity Disorder (ADHD)</a></li>
                            <li><a class="dropdown-item <?php echo ($_SERVER['REQUEST_URI'] == ROOT.'/understand/visual-processing') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/understand/visual-processing">Visual Processing Deficit</a></li>
                            <li><a class="dropdown-item <?php echo ($_SERVER['REQUEST_URI'] == ROOT.'/understand/transition-planning') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/understand/transition-planning">Transition planning</a></li>
                            <li><a class="dropdown-item <?php echo ($_SERVER['REQUEST_URI'] == ROOT.'/understand/gifted-students') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/understand/gifted-students">Gifted Students</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo ($active_page == 'advocacy') ? 'active' : ''; ?>" href="#" id="advocacyDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Advocacy
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="advocacyDropdown">
                            <li><a class="dropdown-item <?php echo ($_SERVER['REQUEST_URI'] == ROOT.'/advocacy/inclusive-education') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/advocacy/inclusive-education">Inclusive Education</a></li>
                            <li><a class="dropdown-item <?php echo ($_SERVER['REQUEST_URI'] == ROOT.'/advocacy/rights-protection') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/advocacy/rights-protection">Rights and Protection</a></li>
                            <li><a class="dropdown-item <?php echo ($_SERVER['REQUEST_URI'] == ROOT.'/advocacy/legislative-agenda') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/advocacy/legislative-agenda">Legislative Agenda</a></li>
                            <li><a class="dropdown-item <?php echo ($active_page == 'research') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/research">Research</a></li>
                            <li><a class="dropdown-item <?php echo ($active_page == 'join-us') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/get-involved">Join Us</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo ($active_page == 'news') ? 'active' : ''; ?>" href="#" id="newsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            News & Media
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="newsDropdown">
                            <li><a class="dropdown-item <?php echo ($active_page == 'news') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/news">News & Updates</a></li>
                            <li><a class="dropdown-item <?php echo ($_SERVER['REQUEST_URI'] == ROOT.'/news/events') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/news/events">Upcoming Events</a></li>
                            <li><a class="dropdown-item <?php echo ($_SERVER['REQUEST_URI'] == ROOT.'/news/media') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/news/media">Photo & Video Gallery</a></li>
                            <li><a class="dropdown-item <?php echo ($_SERVER['REQUEST_URI'] == ROOT.'/news/download') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/news/download">Downloads</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php echo ($active_page == 'tests') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/tests">Assessments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($active_page == 'contact') ? 'active' : ''; ?>" href="<?php echo ROOT; ?>/contact">Contact</a>
                    </li>
                </ul>
                <button type="button" onclick="window.open('https://calendar.app.google/oNQgmMUEVmvg8HA69', '_blank')" class="btn-book ms-lg-3 <?php echo ($active_page == 'contact') ? 'active' : ''; ?>">Appointment</button>
            </div>
        </div>
    </nav>
