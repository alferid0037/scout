<?php
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>⚽ Ethio Online Scouting System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200..1000&family=Rubik:wght@300..900&family=Bebas+Neue&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header -->
    <header id="header" class="header fixed-top">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <a href="#" class="logo d-flex align-items-center scrollto me-auto me-lg-0">
           <img style="border-radius: 100%;" src="images/Football Award Vector.jpg" alt="Football Logo">
             </a>
            <a class="btn-getstarted scrollto" href="register.php">REGISTER</a>
        </div>
    </header>
    
    <!-- Hero Section -->
    <section id="hero" class="registeration_heads">
        <div class="container">
            <div class="hero-content">
                <h1>Ethio Online Scouting System</h1>
                <p>Discovering the next generation of football talent</p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main id="main">
        <!-- CTA Section -->
        <section id="cta" class="cta">
            <div class="container">
                <div class="section-header">
                    <h2 class="display-title">APPLY NOW FOR THE SEASON</h2>
                    <h3>WHO CAN REGISTER AND HOW?</h3>
                    <p class="justified-writing">
                        We enthusiastically welcome young athletes aged 5 to 18, both boys and girls, who share a passion for the beautiful game. 
                        Our scout offers comprehensive training programs meticulously tailored to diverse age groups, ensuring every player receives 
                        appropriate guidance, development, and opportunities for football excellence.
                    </p>
                </div>
                <div class="text-center">
                    <a class="cta-btn" href="register.php">Click Here to Register</a>
                </div>
            </div>
        </section>

        <!-- Age Categories -->
        <section id="age" class="services">
            <div class="section-header">
                <h3>AGE CATEGORIES</h3>
            </div>
            <div class="container">
                <div class="row gy-5">
                    <div class="col-xl-4 col-md-6">
                        <div class="service-item">
                            <div class="img">
                                <img src="https://www.accesswire.com/imagelibrary/3c57cb62-39b3-41c2-b008-22934a459100/877334/AD_4nXcWfD995cuWPrDt1gMnFlcBxTtCsNPc1d3k4OQxnaQpeRgtAzl8AwEH2DF3aAQnvFPZvur3XenXVLxnRWlrKdiXro77lMe6p8Xa_Q-X5GQjvc3vjeEYCssOEPaCgJQSw-tPQxeHHWfGxX6qhZc0ogHJoIXm.jpg" class="img-fluid" alt="U10 Training">
                            </div>
                            <div class="details">
                                <div class="icon">
                                    <i class="category-badge">U10</i>
                                </div>
                                <h3>5 to 10</h3>
                                <p>Train basic football skills, game controlling, coordination. Acquire identity, rules, and personality.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-4 col-md-6">
                        <div class="service-item">
                            <div class="img">
                                <img src="https://jamaicacollege.org/wp-content/uploads/2018/12/IMG_6290-scaled.jpg" class="img-fluid" alt="U15 Training">
                            </div>
                            <div class="details">
                                <div class="icon">
                                    <i class="category-badge">U15</i>
                                </div>
                                <h3>11 to 15</h3>
                                <p>Position training and team tactics. Perfecting skills and individual improvement. Handle physical stress and time pressure.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-4 col-md-6">
                        <div class="service-item">
                            <div class="img">
                                <img src="https://tse3.mm.bing.net/th/id/OIP.ri4v1wAb8aDhFgUMqNnJkAHaFj?r=0&w=1024&h=768&rs=1&pid=ImgDetMain&o=7&rm=3" class="img-fluid" alt="U18 Training">
                            </div>
                            <div class="details">
                                <div class="icon">
                                    <i class="category-badge">U18</i>
                                </div>
                                <h3>16 to 18</h3>
                                <p>Play 9v9 & 11v11. Focus on individual strengths and weaknesses. Team building. Balance football & school.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Training Schedules -->
       <!-- Schedules Section -->
    <section id="schedules" class="schedules">
        <div class="section-header">
            <h3>SCHEDULES</h3>
        </div>
        <div class="container" data-aos="fade-up">
            <ul class="nav nav-tabs row gy-4 d-flex">
                <li class="nav-item col-4 col-md-4 col-lg-4">
                    <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#tab-1">
                        <h4>U6 to U10</h4>
                    </a>
                </li>
                <li class="nav-item col-4 col-md-4 col-lg-4">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-2">
                        <h4>U12 </h4>
                    </a>
                </li>
                <li class="nav-item col-4 col-md-4 col-lg-4">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-3">
                        <h4>U14 to U18</h4>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active show" id="tab-1">
                    <div class="row gy-4">
                        <div class="col-lg-12 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="100">
                            <section id="contact" class="contact">
                                <div class="container">
                                    <div class="row gy-5 gx-lg-5">
                                        <div class="col-lg-4">
                                            <div class="info">
                                                <h3>U6 A & B</h3>
                                                <div class="info-item d-flex">
                                                    <div>
                                                        <h4>Tuesday</h4>
                                                        <p>04:00 pm </p>
                                                    </div>
                                                </div>
                                                <div class="info-item d-flex">
                                                    <div>
                                                        <h4>Saturday</h4>
                                                        <p>09:00 am </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="info">
                                                <h3>U8 A & B</h3>
                                                <div class="info-item d-flex">
                                                    <div>
                                                        <h4>Tuesday</h4>
                                                        <p>04:00 pm </p>
                                                    </div>
                                                </div>
                                                <div class="info-item d-flex">
                                                    <div>
                                                        <h4>Saturday</h4>
                                                        <p>09:00 am </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="info">
                                                <h3>U10 A & B</h3>
                                                <div class="info-item d-flex">
                                                    <div>
                                                        <h4>Tuesday</h4>
                                                        <p>05:10 pm </p>
                                                    </div>
                                                </div>
                                                <div class="info-item d-flex">
                                                    <div>
                                                        <h4>Saturday</h4>
                                                        <p>10:10 am</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div><!-- End Tab Content 1 -->

                <div class="tab-pane" id="tab-2">
                    <div class="row gy-4">
                        <div class="col-lg-12 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="100">
                            <section id="" class="contact">
                                <div class="container">
                                    <div class="row gy-5 gx-lg-5">
                                        <div class="col-lg-6">
                                            <div class="info">
                                                <h3>U12 A & B</h3>
                                                <div class="info-item d-flex">
                                                    <div>
                                                        <h4>Wednesday</h4>
                                                        <p>04:00 pm </p>
                                                    </div>
                                                </div>
                                                <div class="info-item d-flex">
                                                    <div>
                                                        <h4>Saturday</h4>
                                                        <p>10:10 am </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="info">
                                                <h3>U12 C</h3>
                                                <div class="info-item d-flex">
                                                    <div>
                                                        <h4>Tuesday</h4>
                                                        <p>05:10 pm </p>
                                                    </div>
                                                </div>
                                                <div class="info-item d-flex">
                                                    <div>
                                                        <h4>Saturday</h4>
                                                        <p>11:30 am </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab-3">
                    <div class="row gy-4">
                        <div class="col-lg-12 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="100">
                            <section id="" class="contact">
                                <div class="container">
                                    <div class="row gy-5 gx-lg-5">

                                        <div class="col-lg-4">
                                            <div class="info">
                                                <h3>U14 A & B</h3>
                                                <div class="info-item d-flex">
                                                    <div>
                                                        <h4>Wednesday</h4>
                                                        <p>05:10 pm </p>
                                                    </div>
                                                </div>
                                                <div class="info-item d-flex">
                                                    <div>
                                                        <h4>Saturday</h4>
                                                        <p>11:30 am </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="info">
                                                <h3>U 16</h3>
                                                <div class="info-item d-flex">
                                                    <div>
                                                        <h4>Thursday</h4>
                                                        <p>04:00 pm</p>
                                                    </div>
                                                </div>
                                                <div class="info-item d-flex">
                                                    <div>
                                                        <h4>Saturday</h4>
                                                        <p>01:00  pm </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="info">
                                                <h3>U 18 </h3>
                                                <div class="info-item d-flex">
                                                    <div>
                                                        <h4>Monday</h4>
                                                        <p>04:00 pm</p>
                                                    </div>
                                                </div>
                                                <div class="info-item d-flex">
                                                    <div>
                                                        <h4>Saturday</h4>
                                                        <p>02:30 am   </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <h3>Address</h3>
                    <p>Addis Ababa Stadium - ADDIS ABEBA</p>
                    <p>2Q89+5G7, Addis Ababa</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3>Contact</h3>
                    <p>Phone: +251-11/515 6205</p>
                    <p>Email: info@ethioscout.org</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3>Social Media</h3>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-telegram"></i></a>
                    </div>
                </div>
            </div>
            <p class="copyright">&copy; 2024 Ethiopian Football Federation. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
