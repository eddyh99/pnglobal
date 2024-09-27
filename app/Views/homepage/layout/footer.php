    
    
    <?php if(@$flag == 'training'){?>
        <!-- Start of Contact Form -->
        <section class="bg-trainingform">
            <div class="wrapper-trainingform">
                <div class="row position-relative">
                    <div class="col-12 col-lg-6 ps-0 ps-lg-5">
                        <h2 class="f-odor">
                            Join our Professional Training Programs
                        </h2>
                        <p class="f-inter">
                            <span translate='no'> PN Global </span> invites you to join our training programs to become experienced and competent entrepreneurs. Contact us today to find out how we can help you build a successful future in the global landscape.
                        </p>
                        <a href="<?= BASE_URL ?>homepage/contactform?service=<?= base64_encode($title)?>" class="btn-footer-contactform">Contact Form</a>
                    </div>
                    <div class="d-none d-lg-flex col-6 video-trainingform">
                        <video autoplay="" preload="" muted="" loop="" playsinline="">
                            <source src="<?= BASE_URL ?>assets/vid/training-footer.webm" type="video/webm">
                        </video>
                    </div>
                    <img class="img-gear-footer" src="<?= BASE_URL?>assets/img/logo.png" alt="logo pn global">
                </div>
            </div>
        </section>
        <!-- End of Contact Form -->
    <?php } else if(@$flag == 'blockchain') {?>
         <!-- Start of Contact Form -->
         <section class="bg-trainingform blockchain">
            <div class="wrapper-trainingform">
                <div class="row">
                    <div class="col-12 col-lg-6 ps-0 ps-lg-5 py-5">
                        <h2 class="f-odor">
                            Apply Now
                        </h2>
                        <h5 class="f-odor">
                            Join the Selection Process for Our Exclusive Training Programs
                        </h5>
                        <p>
                            By filling out the form at the link below, you can apply to be considered for our exclusive training programs. Our activities are limited to a select number of participants. The selection process is divided into two stages: first, your application will be reviewed based on the submitted form, and only the most compelling candidates will advance to the second stage, which involves an individual interview
                        </p>
                        <a href="<?= BASE_URL ?>homepage/contactform?service=<?= base64_encode($title)?>" class="btn-footer-enrollnow">Contact Form</a>
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
    <?php } else if(@$flag == 'satoshi') { ?>
        <div></div>
    <?php } else {  ?>
          <!-- Start of Contact Form -->
          <section class="bg-contactform">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-8 left-side">
                        <h2 id="g-getintouch" class="f-odor">
                            Get in touch with <span translate='no'> PN Global </span>
                        </h2>
                        <h4 id="g-subgetintouch" class="f-odor">
                            We are Here to Assist You in Every Step of Your Growth and Development Journey
                        </h3>
                        <p id="g-textgetintouch" class="f-inter">
                            If you would like more information about our services or would like to discuss your specific needs with one of our experts, please contact us. Our team of financial consultants, lawyers and accountants is at your disposal to offer you personalized support and timely responses. We are ready to assist you with the utmost professionalism and competence.
                        </p>
                        <a href="<?= BASE_URL ?>homepage/bookingconsultation?service=<?= base64_encode($title)?>" class="btn-footer-contactform">Book a Consultation</a>
                        
                    </div>
                    <div class="d-none d-md-flex col-4 logo-contactform">
                        <img class="img-fluid" style="width: 200px;" src="<?= BASE_URL ?>assets/img/logo.png" alt="img">
                        <p class="logo-text-contactform">
                            <span class="line-animation">
                                Transforming visions
                            </span> 
                            <br>
                            <span class="line-animation" style="color: #BFA573;">
                                into success
                            </span>
                        </p>    
                    </div>
                </div>
            </div>
        </section>
        <!-- End of Contact Form -->
    <?php }   ?>

    <!-- Start of Contact Form -->
    <section class="bg-footer">
        <div class="container">
            <div class="row">
                <div class="col-12 text-link d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="logo-footer">
                            <img src="<?= BASE_URL ?>assets/img/logo.png" alt="img">
                            <p class="logo-text-footer">
                                <span class="line-animation">
                                    Transforming visions
                                </span> 
                                <br>
                                <span class="line-animation">
                                    into success
                                </span>
                            </p>    
                        </div>
                    </div>
                    <div class="list mt-4 mt-md-0">
                        <a class="mb-4" href="<?= BASE_URL ?>homepage/about">About Pn Global</a>
                        <a class="my-4" href="#consulting">Consulting</a>
                        <a class="my-4" href="#service">Services</a>
                        <a class="mt-4" href="#hotdeal">Hot Deal</a>
                        <a class="mt-4" href="<?= BASE_URL ?>homepage/connection">Connections</a>
                        <a class="mt-4" href="<?= BASE_URL ?>homepage/privacy_policy">Privacy Policy</a>
                        <a class="mt-4" href="<?= BASE_URL ?>homepage/terms_conditions">Term & Condition</a>
                    </div>
                </div>
                <div class="col-8 mx-auto border-hr-footer"></div>
                <div class="col-12 my-4 d-flex justify-content-between align-items-center address">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <p class="f-inter text-white mb-4 d-flex">
                                <span>
                                    <svg width="11" height="14" viewBox="0 0 11 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 0C2.45929 0 0 2.191 0 4.9C0 8.575 5.5 14 5.5 14C5.5 14 11 8.575 11 4.9C11 2.191 8.54071 0 5.5 0ZM5.5 6.65C4.41571 6.65 3.53571 5.866 3.53571 4.9C3.53571 3.934 4.41571 3.15 5.5 3.15C6.58429 3.15 7.46429 3.934 7.46429 4.9C7.46429 5.866 6.58429 6.65 5.5 6.65Z" fill="#D1B06B"/>
                                    </svg>
                                </span>
                                <span class="ps-1">
                                    <strong>Company incorporation:</strong> 16192 Coastal Highway, Lewes Delaware 19958 (USA)
                                </span>
                            </p>
                            <p class="f-inter text-white mb-4 d-flex">
                                <span>
                                    <svg width="11" height="14" viewBox="0 0 11 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 0C2.45929 0 0 2.191 0 4.9C0 8.575 5.5 14 5.5 14C5.5 14 11 8.575 11 4.9C11 2.191 8.54071 0 5.5 0ZM5.5 6.65C4.41571 6.65 3.53571 5.866 3.53571 4.9C3.53571 3.934 4.41571 3.15 5.5 3.15C6.58429 3.15 7.46429 3.934 7.46429 4.9C7.46429 5.866 6.58429 6.65 5.5 6.65Z" fill="#D1B06B"/>
                                    </svg>
                                </span>
                                <span class="ps-1">
                                    <strong>International finance department:</strong> 12 Collyer Quay, Ocean Financial Centre, Singapore 049319
                                </span>
                            </p>
                            <p class="f-inter text-white my-4 d-flex">
                                <span>
                                    <svg width="11" height="14" viewBox="0 0 11 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 0C2.45929 0 0 2.191 0 4.9C0 8.575 5.5 14 5.5 14C5.5 14 11 8.575 11 4.9C11 2.191 8.54071 0 5.5 0ZM5.5 6.65C4.41571 6.65 3.53571 5.866 3.53571 4.9C3.53571 3.934 4.41571 3.15 5.5 3.15C6.58429 3.15 7.46429 3.934 7.46429 4.9C7.46429 5.866 6.58429 6.65 5.5 6.65Z" fill="#D1B06B"/>
                                    </svg>     
                                </span>
                                <span class="ps-1">
                                    <strong>Crypto broker division:</strong> Mahe, Seychelles, Jivan’s complex, Suite 708, Global Village, Abacus, Seychelles
                                </span>                           
                            </p>
                        </div>
                        <div class="col-12 col-md-4">
                            <p class="f-inter text-white mb-4 d-flex">
                                <span>
                                    <svg width="11" height="14" viewBox="0 0 11 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 0C2.45929 0 0 2.191 0 4.9C0 8.575 5.5 14 5.5 14C5.5 14 11 8.575 11 4.9C11 2.191 8.54071 0 5.5 0ZM5.5 6.65C4.41571 6.65 3.53571 5.866 3.53571 4.9C3.53571 3.934 4.41571 3.15 5.5 3.15C6.58429 3.15 7.46429 3.934 7.46429 4.9C7.46429 5.866 6.58429 6.65 5.5 6.65Z" fill="#D1B06B"/>
                                    </svg>     
                                </span>
                                <span class="ps-1">
                                    <strong>Head quarter:</strong> 46 street, 247W Platinum Tower, New York,NY 10036 (USA)
                                </span>                           
                            </p>
                            <p class="f-inter text-white mb-4 d-flex">
                                <span>
                                    <svg width="11" height="14" viewBox="0 0 11 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 0C2.45929 0 0 2.191 0 4.9C0 8.575 5.5 14 5.5 14C5.5 14 11 8.575 11 4.9C11 2.191 8.54071 0 5.5 0ZM5.5 6.65C4.41571 6.65 3.53571 5.866 3.53571 4.9C3.53571 3.934 4.41571 3.15 5.5 3.15C6.58429 3.15 7.46429 3.934 7.46429 4.9C7.46429 5.866 6.58429 6.65 5.5 6.65Z" fill="#D1B06B"/>
                                    </svg>
                                </span>
                                <span class="ps-1">
                                    <strong>Operational Department for Customer Funds Management</strong> 128 City Road London EC1V 2NX (UK)
                                </span>
                            </p>
                            <p class="f-inter text-white mb-4 d-flex">
                                <span>
                                    <svg width="11" height="14" viewBox="0 0 11 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 0C2.45929 0 0 2.191 0 4.9C0 8.575 5.5 14 5.5 14C5.5 14 11 8.575 11 4.9C11 2.191 8.54071 0 5.5 0ZM5.5 6.65C4.41571 6.65 3.53571 5.866 3.53571 4.9C3.53571 3.934 4.41571 3.15 5.5 3.15C6.58429 3.15 7.46429 3.934 7.46429 4.9C7.46429 5.866 6.58429 6.65 5.5 6.65Z" fill="#D1B06B"/>
                                    </svg>
                                </span>
                                <span class="ps-1">
                                    <strong>Operational detachment:</strong> Benoa Square, Jl. Bypass Ngurah Rai A Kedonganan No.21, Jimbaran, Kec. Kuta, Kabupaten Badung, Bali 80361, Indonesia
                                </span>
                            </p>
                          
                        </div>
                        <div class="col-12 col-md-4">
                            <p class="f-inter text-white mb-4 d-flex">
                                <span>
                                    <svg width="11" height="14" viewBox="0 0 11 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 0C2.45929 0 0 2.191 0 4.9C0 8.575 5.5 14 5.5 14C5.5 14 11 8.575 11 4.9C11 2.191 8.54071 0 5.5 0ZM5.5 6.65C4.41571 6.65 3.53571 5.866 3.53571 4.9C3.53571 3.934 4.41571 3.15 5.5 3.15C6.58429 3.15 7.46429 3.934 7.46429 4.9C7.46429 5.866 6.58429 6.65 5.5 6.65Z" fill="#D1B06B"/>
                                    </svg>     
                                </span>
                                <span class="ps-1">
                                    <strong>International monetary departments:</strong> Business Location: 109 Bismarckia Way - George Town Cayman Islands
                                </span>                           
                            </p>
                            <p class="f-inter text-white mb-4 d-flex">
                                <span>
                                    <svg width="11" height="14" viewBox="0 0 11 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 0C2.45929 0 0 2.191 0 4.9C0 8.575 5.5 14 5.5 14C5.5 14 11 8.575 11 4.9C11 2.191 8.54071 0 5.5 0ZM5.5 6.65C4.41571 6.65 3.53571 5.866 3.53571 4.9C3.53571 3.934 4.41571 3.15 5.5 3.15C6.58429 3.15 7.46429 3.934 7.46429 4.9C7.46429 5.866 6.58429 6.65 5.5 6.65Z" fill="#D1B06B"/>
                                    </svg>     
                                </span>
                                <span class="ps-1">
                                    <strong>Brokers stock division:</strong> 11 Wallstreet, New York,  NY 10005 (USA)
                                </span>                           
                            </p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    <!-- End of Contact Form -->
    
    <!-- JQUERY -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.4.3/js/foundation.min.js"></script>
    
    <!-- GSAP -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/split-type"></script>
    
    <!-- Telephone Code -->
    <script src="<?= BASE_URL?>assets/libs/intl-tel-input-master/build/js/intlTelInput.js"></script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= IDGTAG ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '<?= IDGTAG ?>');
    </script>
    
    <!-- Custom General Javascript -->
    <script src="<?= BASE_URL ?>assets/js/script.js"></script>

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