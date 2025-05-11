<?php if (!isset($footer) || $footer !== false): ?>

    <?php if (@$flag == 'training' || @$flag == 'comingsoon') { ?>
        <!-- Start of Contact Form -->
        <section class="bg-trainingform">
            <div class="wrapper-trainingform">
                <div class="row position-relative">
                    <div class="col-12 col-lg-6 ps-0 ps-lg-5">
                        <h2 class="">
                            Join our Professional Training Programs
                        </h2>
                        <p class="f-inter">
                            <span translate='no'> PN Global </span> invites you to join our training programs to become experienced and competent entrepreneurs. Contact us today to find out how we can help you build a successful future in the global landscape.
                        </p>
                        <a href="<?= BASE_URL ?>homepage/contactform?service=<?= base64_encode($title) ?>" class="btn-footer-contactform">Contact Form</a>
                    </div>
                    <div class="d-none d-lg-flex col-6 video-trainingform">
                        <video autoplay="" preload="" muted="" loop="" playsinline="">
                            <source src="<?= BASE_URL ?>assets/vid/training-footer.webm" type="video/webm">
                        </video>
                    </div>
                    <img class="img-gear-footer" src="<?= BASE_URL ?>assets/img/logo.png" alt="logo pn global">
                </div>
            </div>
        </section>
        <!-- End of Contact Form -->
    <?php } else if (@$flag == 'blockchain') { ?>
        <!-- Start of Contact Form -->
        <section class="bg-trainingform blockchain">
            <div class="wrapper-trainingform">
                <div class="row">
                    <div class="col-12 col-lg-6 ps-0 ps-lg-5 py-5">
                        <h2 class="">
                            Enroll Now
                        </h2>
                        <h5 class="">
                            How to get free online training
                        </h5>
                        <h5 class="fw-bold">
                            Follow the simple steps below:
                        </h5>
                        <div class="mt-4">
                            <ol>
                                <li class="mt-3">Follow this INSTAGRAM profile: <a href="https://www.instagram.com/principe.nerini_official/" class="fw-bold d-inline">https://www.instagram.com/ principe.nerini_official/</a> </li>
                                <li class="mt-3">
                                    Every time a new course is organised, a Reel will be published on the profiles announcing the event, just comment "FRIENDS";
                                </li>
                                <li class="mt-3">
                                    Once you have commented, if you are selected, you will be added to the close friends list;
                                </li>
                                <li class="mt-3">
                                    Take live lessons exclusively for close friends for free and Good Luck!
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="d-none d-lg-flex align-items-center col-6 video-trainingform">
                        <video autoplay="" preload="" muted="" loop="" playsinline="">
                            <source src="<?= BASE_URL ?>assets/vid/footer-blockchain.webm" type="video/webm">
                        </video>
                    </div>
                </div>
            </div>
        </section>
        <!-- End of Contact Form -->
        <!-- Start of Contact Form -->
        <section class="bg-contactform">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-8 left-side">
                        <h2 id="g-getintouch" class="">
                            Get in touch with <span translate='no'> PN Global </span>
                        </h2>
                        <h4 id="g-subgetintouch" class="f-noto">
                            We are Here to Assist You in Every Step of Your Growth and Development Journey
                        </h4>
                        <p id="g-textgetintouch" class="f-noto">
                            If you would like more information about our services or would like to discuss your specific needs with one of our experts, please contact us. Our team of financial consultants, lawyers and accountants is at your disposal to offer you personalized support and timely responses. We are ready to assist you with the utmost professionalism and competence.
                        </p>
                        <a href="<?= BASE_URL ?>homepage/bookingconsultation?service=<?= base64_encode($title) ?>" class="btn-footer-contactform">Book a Consultation</a>

                    </div>
                    <div class="d-none d-md-flex col-4 logo-contactform">
                        <img class="img-fluid" style="width: 200px;" src="<?= BASE_URL ?>assets/img/logo.png" alt="img">
                        <p class="logo-text-contactform f-noto">
                            <span class="line-animation">
                                ASSET
                            </span>
                            <br>
                            <span class="line-animation" style="color: #BFA573;">
                                MANAGEMENT
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- End of Contact Form -->

    <?php } else if (@$flag == 'satoshi') { ?>
        <!-- Start of Contact Form -->
        <section class="bg-contactform">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-8 left-side">
                        <h2 id="g-getintouch" class="">
                            Get in touch with <span translate='no'> PN Global </span>
                        </h2>
                        <h4 id="g-subgetintouch" class="f-noto">
                            We are Here to Assist You in Every Step of Your Growth and Development Journey
                        </h4>
                        <p id="g-textgetintouch" class="f-noto">
                            If you would like more information about our services or would like to discuss your specific needs with one of our experts, please contact us. Our team of financial consultants, lawyers and accountants is at your disposal to offer you personalized support and timely responses. We are ready to assist you with the utmost professionalism and competence.
                        </p>
                        <a href="<?= BASE_URL ?>homepage/bookingconsultation?service=<?= base64_encode($title) ?>" class="btn-footer-contactform">Book a Consultation</a>

                    </div>
                    <div class="d-none d-md-flex col-4 logo-contactform">
                        <img class="img-fluid" style="width: 200px;" src="<?= BASE_URL ?>assets/img/logo.png" alt="img">
                        <p class="logo-text-contactform f-noto">
                            <span class="line-animation">
                                ASSET
                            </span>
                            <br>
                            <span class="line-animation" style="color: #BFA573;">
                                MANAGEMENT
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- End of Contact Form -->
    <?php } else {  ?>
        <!-- Start of Contact Form -->
        <section class="bg-contactform">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-8 left-side">
                        <h2 id="g-getintouch" class="">
                            Get in touch with <span translate='no'> PN Global </span>
                        </h2>
                        <h4 id="g-subgetintouch" class="f-noto">
                            We are Here to Assist You in Every Step of Your Growth and Development Journey
                            </h3>
                            <p id="g-textgetintouch" class="f-noto">
                                If you would like more information about our services or would like to discuss your specific needs with one of our experts, please contact us. Our team of financial consultants, lawyers and accountants is at your disposal to offer you personalized support and timely responses. We are ready to assist you with the utmost professionalism and competence.
                            </p>
                            <a href="<?= BASE_URL ?>homepage/bookingconsultation?service=<?= base64_encode($title) ?>" class="btn-footer-contactform">Book a Consultation</a>

                    </div>
                    <a class="d-none d-md-flex col-4 logo-contactform" href="<?= BASE_URL ?>">
                        <img class="img-fluid" style="width: 179px;" src="<?= BASE_URL ?>assets/img/logo.png" alt="img">
                        <p class="logo-text-contactform f-noto">
                            <span class="line-animation" translate="no" style="color: #BFA573;">
                                ASSET
                            </span>
                            <span class="line-animation text-white" translate="no">
                                MENAGEMENT
                            </span>
                        </p>
                    </a>
                </div>
            </div>
        </section>
        <!-- End of Contact Form -->
    <?php }   ?>

    <!-- Start of Contact Form -->
    <section class="bg-footer">
        <div class="container">
            <div class="row">
                <!-- Kolom Kiri - Logo -->
                <div class="col-12 col-md-4 d-flex justify-content-center justify-content-md-start mb-4 mb-md-0">
                    <a href="<?= BASE_URL ?>" class="logo-footer">
                        <img src="<?= BASE_URL ?>assets/img/logo.png" alt="PN Global Logo" class="img-fluid">
                    </a>
                </div>

                <!-- Kolom Tengah - Asset Management & Contact Form -->
                <div class="col-12 col-md-4 text-center mb-4 mb-md-0">
                    <div class="d-flex flex-column align-items-center">
                        <p class="logo-text-footer f-noto">
                            <span class="text-gold" translate="no">ASSET</span>
                            <span class="text-white" translate="no">MENAGEMENT</span>
                        </p>
                        <a class="btn btn-contact-form text-uppercase px-4 pb-2"
                            href="<?= BASE_URL ?>homepage/contactform?service=<?= base64_encode($title) ?>">
                            Contact Form
                        </a>
                    </div>
                </div>

                <!-- Kolom Kanan - List Link -->
                <div class="col-12 col-md-4 mt-4 mt-md-0">
                    <div class="list ps-md-4">
                        <div class="d-flex flex-column gap-2">
                            <p></p>
                            <a class="footer-link" href="<?= BASE_URL ?>homepage">Hot Deal</a>
                            <a class="footer-link" href="<?= BASE_URL ?>homepage/service?service=<?= base64_encode('satoshi_signal') ?>">Services Infoarmation</a>
                            <a class="footer-link" href="<?= BASE_URL ?>homepage">Training Courses</a>
                            <a class="footer-link" href="<?= BASE_URL ?>homepage/about">About Pn Global</a>
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="col-12 mx-auto border-hr-footer"></div>
                <div class="col-12 my-4 d-flex justify-content-between align-items-center address">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <ul class="list-unstyled footer-list">
                                <li class="mb-4">
                                    <strong>Company incorporation:</strong> 16192 Coastal Highway, Lewes Delaware 19958 (USA)
                                </li>
                                <li class="mb-4">
                                    <strong>International finance department:</strong> 12 Collyer Quay, Ocean Financial Centre, Singapore 049319
                                </li>
                                <li class="mb-4">
                                    <strong>International monetary departments:</strong> 109 Bismarckia Way - George Town Cayman Islands (Business Location)
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-md-4">
                            <ul class="list-unstyled footer-list">
                                <li class="mb-4">
                                    <strong>Head quarter:</strong> 46 street, 247W Platinum Tower, New York,NY 10036 (USA)
                                </li>
                                <li class="mb-4">
                                    <strong>Brokers stock division:</strong> 11 Wallstreet, New York, NY 10005 (USA)
                                </li>
                                <li class="mb-4">
                                    <strong>Crypto broker division:</strong> Mahe, Seychelles, Jivan's complex, Suite 708, Global Village, Abacus, Seychelles
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-md-4">
                            <ul class="list-unstyled footer-list">
                                <li class="mb-4">
                                    <strong>Operational detachment:</strong> Benoa Square, Jl. Bypass Ngurah Rai A Kedonganan No.21, Jimbaran, Kec. Kuta, Kabupaten Badung, Bali 80361, Indonesia
                                </li>
                            </ul>
                            <div class="d-flex gap-4 mt-4">
                                <a href="#" class="footer-link">Terms & Conditions</a>
                                <a href="#" class="footer-link">Privacy Policy</a>
                            </div>
                            <a href="https://moneyindustrialfactory.io" target="_blank" class="mif-link">
                                <img class='img-fluid' src='<?= BASE_URL ?>assets/img/powered-mif.png' alt='img'>
                                <p class="mif-text mt-2 mb-0">Money Industrial Factory</p>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

<?php endif; ?>


<!-- JQUERY -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.4.3/js/foundation.min.js"></script>

<!-- GSAP -->
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
<script src="https://unpkg.com/split-type"></script>

<!-- Telephone Code -->
<script src="<?= BASE_URL ?>assets/libs/intl-tel-input-master/build/js/intlTelInput.js"></script>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= IDGTAG ?>"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', '<?= IDGTAG ?>');
</script>

<!-- Custom General Javascript -->
<script src="<?= BASE_URL ?>assets/js/script.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init();
</script>

<?php
if (@isset($extra)) {
    echo view(@$extra);
}
?>

<?php
if (@isset($extragsap)) {
    echo view(@$extragsap);
}
?>

</body>

</html>