    <!-- Start of Contact Form -->
    <section class="bg-contactform">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-9 left">
                    <h1 id="g-getintouch" style="clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 100%);" class="f-notoserif">
                        Get in touch with <span translate='no'> PN Global </span>
                    </h1>
                    <h3 id="g-subgetintouch" style="clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 100%);" class="f-notoserif">
                        We are Here to Assist You in Every Step of Your Growth and Development Journey
                    </h3>
                    <p id="g-textgetintouch" style="clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 100%);" class="f-notoserif">
                        If you would like more information about our services or would like to discuss your specific needs with one of our experts, please contact us. Our team of financial consultants, lawyers and accountants is at your disposal to offer you personalized support and timely responses. We are ready to assist you with the utmost professionalism and competence.
                    </p>
                    <a href="<?= BASE_URL ?>homepage/contactus" class="btn btn-contactform my-4">Contact Form</a>
                </div>
                <div class="col-3 d-none d-md-flex justify-content-end align-items-center">
                    <img class="img-fluid" src="<?= BASE_URL ?>assets/img/logo-text.png" alt="img">
                </div>
            </div>
        </div>
    </section>
    <!-- End of Contact Form -->

    <!-- Start of Contact Form -->
    <section class="bg-footer">
        <div class="container">
            <div class="row">
                <div class="col-12 my-4">
                    <img class="img-fluid" src="<?= BASE_URL ?>assets/img/logo-text.png" alt="img">
                    <p class="f-inter text-white fw-bold">
                        <svg width="16" height="23" viewBox="0 0 16 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 0C3.57714 0 0 3.5995 0 8.05C0 14.0875 8 23 8 23C8 23 16 14.0875 16 8.05C16 3.5995 12.4229 0 8 0ZM8 10.925C6.42286 10.925 5.14286 9.637 5.14286 8.05C5.14286 6.463 6.42286 5.175 8 5.175C9.57714 5.175 10.8571 6.463 10.8571 8.05C10.8571 9.637 9.57714 10.925 8 10.925Z" fill="#D1B06B"/>
                        </svg>
                        Head quarter: 16192 Coastal Highway, Lewes Delaware 19958 (USA)
                    </p>
                    <p class="f-inter text-white fw-bold">
                        <svg width="16" height="23" viewBox="0 0 16 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 0C3.57714 0 0 3.5995 0 8.05C0 14.0875 8 23 8 23C8 23 16 14.0875 16 8.05C16 3.5995 12.4229 0 8 0ZM8 10.925C6.42286 10.925 5.14286 9.637 5.14286 8.05C5.14286 6.463 6.42286 5.175 8 5.175C9.57714 5.175 10.8571 6.463 10.8571 8.05C10.8571 9.637 9.57714 10.925 8 10.925Z" fill="#D1B06B"/>
                        </svg>
                        Operational detachment: Benoa Square, Jl. Bypass Ngurah Rai A Kedonganan No.21, 
                        Jimbaran, Kec. Kuta, Kabupaten Badung, Bali 80361, Indonesia
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- End of Contact Form -->
    
    <!-- JQUERY -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    
    <!-- GSAP -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/split-type"></script>
    <!-- <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/16327/SplitText3.min.js"></script> -->
    
    <!-- Telephone Code -->
    <script src="<?= base_url()?>assets/libs/intl-tel-input-master/build/js/intlTelInput.js"></script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-QG231EBN92"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-QG231EBN92');
    </script>
    
    <!-- Custom General Javascript -->
    <script src="<?= base_url() ?>assets/js/script.js"></script>

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