        </div>
        <!-- Wrapper END -->
        
        <!-- Footer -->
        <!-- <footer class="iq-footer">
            <div class="container-fluid">
                <div class="row">
                <div class="col-lg-6">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="privacy-policy.html">Privacy Policy</a></li>
                        <li class="list-inline-item"><a href="terms-of-service.html">Terms of Use</a></li>
                    </ul>
                </div>
                <div class="col-lg-6 text-right">
                    Copyright 2024 <a href="#">@</a> All Rights Reserved.
                </div>
                </div>
            </div>
        </footer> -->
        <!-- Footer END -->

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/jquery.min.js"></script>
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/popper.min.js"></script>
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/bootstrap.min.js"></script>
        <!-- Appear JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/jquery.appear.js"></script>
        <!-- Countdown JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/countdown.min.js"></script>
        <!-- Counterup JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/waypoints.min.js"></script>
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/jquery.counterup.min.js"></script>
        <!-- Wow JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/wow.min.js"></script>
        <!-- Apexcharts JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/apexcharts.js"></script>
        <!-- Slick JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/slick.min.js"></script>
        <!-- Select2 JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <!-- Owl Carousel JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/owl.carousel.min.js"></script>
        <!-- Magnific Popup JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/jquery.magnific-popup.min.js"></script>
        <!-- Smooth Scrollbar JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/smooth-scrollbar.js"></script>
        <!-- lottie JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/lottie.js"></script>
        <!-- am core JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/core.js"></script>
        <!-- am charts JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/charts.js"></script>
        <!-- am animated JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/animated.js"></script>
        <!-- am kelly JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/kelly.js"></script>
        <!-- am maps JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/maps.js"></script>
        <!-- Morris JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/morris.js"></script>
        <!-- Morris min JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/morris.min.js"></script>
        <!-- Flatpicker Js -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/flatpickr.js"></script>
        <!-- Style Customizer -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/style-customizer.js"></script>
        <!-- Chart Custom JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/chart-custom.js"></script>
        <!-- Sweet Alert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Summer Note -->
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
        <!-- Datatables JS -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <!-- Custom JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/custom.js"></script>
        <!-- Format Price -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/1.8.2/autoNumeric.js"></script>

        <script>
            $(".price-input").autoNumeric('init', {
                aSep: ',',
                aDec: '.',
                aForm: true,
                vMax: '99999999999',
                vMin: '0'
            });
        </script>

        <?php
        if (isset($extra)) {
            echo view(@$extra);
        }
	    ?>
   </body>
</html>