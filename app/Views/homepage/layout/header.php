<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <!-- Favicons -->
    <link href="<?= BASE_URL ?>assets/img/logo.png" rel="icon">
    <link href="<?= BASE_URL ?>assets/img/logo.png" rel="apple-touch-icon">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Odor+Mean+Chey&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Icon Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Telephone Code -->
    <link href="<?= BASE_URL ?>assets/libs/intl-tel-input-master/build/css/intlTelInput.css" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Stripe -->
    <script src="https://js.stripe.com/v3/"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/style/css/main.css">
</head>

<body>
    <?php if (!isset($nav) || $nav !== false): ?>
        <!-- Start of Navbar -->
        <nav class="navbar navbar-expand-xxl <?= @$navoption ? 'position-relative' : '' ?> <?= (@$darkNav) ? 'navbar-dark-full' : '' ?>">
            <div class="container">
                <a class="navbar-logo d-flex align-items-center gap-3" href="<?= BASE_URL ?>">
                    <img class="logo" src="<?= BASE_URL ?>assets/img/logo-big.png" alt="logo pnglobal">
                    <span class="logo-text">
                        <span class="text-gold" translate="no">Asset</span>
                        <span class="text-white" translate="no">Menagement</span>
                    </span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <div class="openbtn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <!-- <li class="nav-item me-0 me-xl-4 <?= (current_url() === BASE_URL('index.php/homepage/hotdeals')) ? 'active' : '' ?>">
                            <a class="nav-link" translate="no" aria-current="page" href="<?= BASE_URL ?>homepage/service?service=<?= base64_encode('satoshi_signal') ?>">HOT <br> DEAL</a>
                        </li> -->
                        <li class="nav-item dropdown me-0 me-xl-2">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                PRODUCTS
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>homepage/service?service=<?= base64_encode('btc_elite_management') ?>">HEDGE FUND</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>homepage/service?service=<?= base64_encode('satoshi_signal') ?>">SATOSHI</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>homepage/service?service=<?= base64_encode('lux_btc_brokers') ?>">BROKER LUX</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown me-0 me-xl-2">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                SERVICES
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>homepage/service?service=<?= base64_encode('crypto_consulting') ?>">CRYPTO CONSULTING</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>homepage/service?service=<?= base64_encode('passive_income') ?>">PASSIVE INCOMING</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>homepage/service?service=<?= base64_encode('portfolio_creation') ?>">PORTFOLIO CREATION</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>homepage/service?service=<?= base64_encode('accumulation_plan') ?>">ACCUMULATION PLAN</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>homepage/service?service=<?= base64_encode('wealth_consulting') ?>">WEALTH CONSULTING</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>homepage/service?service=<?= base64_encode('funds_reallocation') ?>">FUNDS REALLOCATION</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>homepage/service?service=<?= base64_encode('tax_reduction') ?>">TAX REDUCTION</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>homepage/service?service=<?= base64_encode('capital_protection') ?>">CAPITAL PROTECTION</a></li>
                            </ul>
                        </li>
                        <li class="nav-item me-0 me-xl-2">
                            <a class="nav-link" aria-current="page" href="<?= BASE_URL ?>homepage/training_course">TRAINING <br> COURSES</a>
                        </li>
                        <li class="nav-item me-0 me-xl-2">
                            <a class="nav-link" href="<?= BASE_URL ?>?type=service">FINANCIAL <br> BLOG</a>
                        </li>
                        <!-- <li class="nav-item me-0 me-lg-3 d-flex align-items-center justify-content-center">
                        <a class="btn-navbar-referral" href="<?= BASE_URL ?>">LOGIN WITH REFERRAL</a>
                    </li> -->
                        <!-- <li class="nav-item mt-2 mt-lg-0 d-flex align-items-center justify-content-center">
                        <a class="btn-navbar-contactform" href="<?= BASE_URL ?>homepage/contactreferral">Get Referral</a>
                    </li> -->
                    </ul>
                    <div class="nav-buttons">
                        <a class="btn-navbar-referral" href="<?= BASE_URL ?>auth">LOGIN/SIGNUP</a>
                        <!-- <a class="btn-navbar-contactform" href="<?= BASE_URL ?>homepage/contactreferral">Get Referral</a> -->
                    </div>
                </div>
            </div>
        </nav>
        <!-- End of Navbar -->
    <?php endif; ?>