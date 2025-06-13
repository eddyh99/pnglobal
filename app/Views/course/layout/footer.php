
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
        <!-- lottie JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/lottie.js"></script>
        <!-- Slick JavaScript --> 
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/slick.min.js"></script>
        <!-- Select2 JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/select2.min.js"></script>
        <!-- Owl Carousel JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/owl.carousel.min.js"></script>
        <!-- Magnific Popup JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/jquery.magnific-popup.min.js"></script>
        <!-- Smooth Scrollbar JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/smooth-scrollbar.js"></script>
        <!-- Style Customizer -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/style-customizer.js"></script>
        <!-- Chart Custom JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/chart-custom.js"></script>
        <!-- Custom JavaScript -->
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/custom.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Datatables JS -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <?php
        if (isset($extra)) {
            echo view(@$extra);
        }
	?>
   </body>
</html>
