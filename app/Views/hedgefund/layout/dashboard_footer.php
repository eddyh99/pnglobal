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
        <script src="<?= BASE_URL?>assets/js/admin/mandatory/select2.min.js"></script>
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
        <script src="//cdn.datatables.net/plug-ins/2.3.2/api/sum().js"></script>

        <script>
            // NEW FEATURE: Tambahkan fungsi untuk icon share, icon copy, dan Show QR Code
            var referralLink = $('.referral-link a').attr('href');
    
            // Event listener untuk icon share (svg pertama di .referral-qr)
            $('.referral-qr svg').eq(0).on('click', function() {
                if (navigator.share) {
                    navigator.share({
                        title: 'Referral Link',
                        url: referralLink
                    }).then(function() {
                        console.log('Referral link shared successfully');
                    }).catch(function(error) {
                        console.error('Error sharing referral link:', error);
                    });
                } else {
                    alert('Your browser does not support the Share feature.');
                }
            });
    
            // Event listener untuk icon copy (svg kedua di .referral-qr)
            $('.referral-qr svg').eq(1).on('click', function() {
                navigator.clipboard.writeText(referralLink).then(function() {
                    alert('Referral link copied to clipboard!');
                }).catch(function(err) {
                    alert('Failed to copy referral link.');
                });
            });
    
            // Event listener untuk teks 'Show QR Code' (p element di .referral-qr)
            $('.referral-qr p').on('click', function() {
                var qrDiv = $('.qr-code-container');
                var buttonPosition = $(this).offset(); // Get the position of the clicked button
                var buttonWidth = $(this).outerWidth(); // Get the width of the button
                var qrContainerWidth = 200; // Pertahankan lebar QR code container yang asli
                var additionalOffset = 20; // Additional downward offset in pixels (adjust as needed)
                var rightShift = 30; // Jarak tambahan ke kanan (dalam pixel)
    
                if (qrDiv.length === 0) {
                    qrDiv = $('<div class="qr-code-container" style="position: fixed; top: ' + (buttonPosition.top + $(this).outerHeight() + additionalOffset) + 'px; left: ' + (buttonPosition.left + buttonWidth + rightShift - qrContainerWidth) + 'px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 10000; width: ' + qrContainerWidth + 'px;"></div>');
    
                    // QR Code image dengan ukuran yang sama
                    var qrImg = $('<img style="display: block; margin: 0 auto; width: 150px; height: 150px;">').attr('src', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' + encodeURIComponent(referralLink));
    
                    // Tombol yang lebih menarik
                    var closeBtn = $('<button style="display: block; margin: 10px auto 0; padding: 6px 15px; background-color: #c9a95b; color: #000; border: none; border-radius: 4px; cursor: pointer; width: 80px;">Close</button>');
    
                    closeBtn.on('click', function() {
                        qrDiv.remove();
                    });
    
                    qrDiv.append(qrImg).append(closeBtn);
                    $('body').append(qrDiv);
                } else {
                    qrDiv.toggle();
                }
    
                // Mengatur posisi setelah element ditambahkan ke DOM
                qrDiv.css({
                    'top': buttonPosition.top + $(this).outerHeight() + 30, // Mengubah offset top menjadi 30px
                    'left': buttonPosition.left + $(this).outerWidth() - qrDiv.outerWidth()
                });
            });
        </script>

        <?php
        if (isset($extra)) {
            echo view(@$extra);
        }
	    ?>
   </body>
</html>