<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title?></title>

    <!-- Favicons -->
    <link href="<?= BASE_URL ?>assets/img/logo.png" rel="icon">
    <link href="<?= BASE_URL ?>assets/img/logo.png" rel="apple-touch-icon">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Odor+Mean+Chey&display=swap" rel="stylesheet">

    <!-- Icon Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Telephone Code -->
    <link href="<?= base_url()?>assets/libs/intl-tel-input-master/build/css/intlTelInput.css" rel="stylesheet">
    
    <!-- Bootstrap -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/livecanvas-team/ninjabootstrap/dist/css/bootstrap.min.css" media="all">

    <!-- Stripe -->
    <script src="https://js.stripe.com/v3/"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/homepage.css">


</head>
<body>
      <!-- Start of Navbar -->
      <nav id="navbar" class="navbar fixed-top navbar-expand-lg w-100">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?= BASE_URL ?>">
                <img class="img-fluid" width="70" height="70" src="<?= BASE_URL ?>assets/img/logo.png " alt="">
                <span class="d-none d-md-block ps-3 text-uppercase fs-6 text-white fw-bold" style="letter-spacing: 3px;">
                    Transforming visions <br>
                    <span style="color: #BFA573;">
                        into success
                    </span>
                </span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <!-- <span class="navbar-toggler-icon"></span> -->
                <span class="" role="button" ><i class="fa fa-bars fs-1" aria-hidden="true" style="color:#e6e6ff"></i></span>
            </button>

            <div class="offcanvas offcanvas-start bg-black w-100" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">

                <div class="offcanvas-header">

                    <a class="navbar-brand d-flex align-items-center" href="#">
                        <img class="img-fluid" width="70" height="70" src="<?= BASE_URL ?>assets/img/logo.png " alt="">
                        <span class="d-block d-lg-none ps-3 text-uppercase text-white fw-bold" style="letter-spacing: 3px; font-size: 10px;">
                            Transforming visions <br>
                            <span style="color: #BFA573;">
                                into success
                            </span>
                        </span>
                    </a>

                    <span data-bs-dismiss="offcanvas" aria-label="Close">
                        <svg width="33" height="36" viewBox="0 0 33 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="0.5" y="3.5" width="32" height="32" rx="9.5" fill="black" stroke="#BFA573"/>
                            <path d="M7.925 27L14.475 18.05V21.35L8.125 12.55H13.525L17.25 17.925L14.95 17.95L18.625 12.55H23.825L17.5 21.15V17.925L24.125 27H18.6L14.85 21.375H17.1L13.425 27H7.925Z" fill="white"/>
                        </svg>
                    </span>

                </div>

                <div class="offcanvas-body align-items-end">
                    <ul class="navbar-nav ms-auto align-items-lg-end gap-3">

                        <li class="dropdown dropdown-fullwidth nav-item lc-block position-static">
                            <a class=" text-uppercase btn btn-navbar" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                See Services
                            </a>
                            <div class="dropdown-menu p-0 start-0 end-0 top-100 mx-auto w-100 shadow-lg overflow-hidden" style="max-width:var(--bs-breakpoint-xxl); transform: none!important;">
                                <div class="row row-cols-1 row-cols-lg-2 bg-black nav-seeservice">
                                    <div class="col position-relative">
                                        <img class="w-100 object-fit-cover" src="<?= BASE_URL ?>assets/img/img-1.webp" alt="">
                                    </div>
                                    <div class="col position-relative">
                                        <a href="#" class="position-absolute top-5 end-10">
                                            <svg width="33" height="36" viewBox="0 0 33 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="0.5" y="3.5" width="32" height="32" rx="9.5" fill="black" stroke="#BFA573"/>
                                                <path d="M7.925 27L14.475 18.05V21.35L8.125 12.55H13.525L17.25 17.925L14.95 17.95L18.625 12.55H23.825L17.5 21.15V17.925L24.125 27H18.6L14.85 21.375H17.1L13.425 27H7.925Z" fill="white"/>
                                            </svg>
                                        </a>
                                        <ul class="position-relative top-10 pe-8">
                                            <li>
                                                <a class="link-navbar-text text-decoration-none fs-2" href="<?php echo BASE_URL . "homepage/service?service=" . base64_encode("finance_advice_investment")?>">
                                                    Finance advice, assets and investment
                                                </a>
                                            </li>
                                            <li class="my-5">
                                                <a class="link-navbar-text text-decoration-none fs-2" href="<?php echo BASE_URL . "homepage/service?service=" . base64_encode("strategic_optimization")?>">
                                                    Strategic and tax optimization
                                                </a>
                                            </li>
                                            <li class="my-5">
                                                <a class="link-navbar-text text-decoration-none fs-2" href="<?php echo BASE_URL . "homepage/service?service=" . base64_encode("international_expansion_management")?>">
                                                    International expansion and management
                                                </a>
                                            </li>
                                            <li class="my-5">
                                                <a class="link-navbar-text text-decoration-none fs-2" href="<?php echo BASE_URL . "homepage/service?service=" . base64_encode("legal_tax_accounting")?>">
                                                    Legal, tax, and accounting consulting
                                                </a>
                                            </li>
                                            <li class="my-5">
                                                <a class="link-navbar-text text-decoration-none fs-2" href="<?php echo BASE_URL . "homepage/service?service=" . base64_encode("professional_enterpreneurial_training")?>">
                                                    Professional entrepreneurial training
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- End of Navbar -->
