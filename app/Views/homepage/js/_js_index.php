<script>
    $("document").ready(function($) {
        var nav = $('#navbar');

        $(window).scroll(function() {
            if ($(this).scrollTop() > 600) {
                nav.addClass("active");
            } else {
                nav.removeClass("active");
            }
        });
    });

    $(".openbtn").click(function() {
        $(this).toggleClass('active');
    });

    $(function() {
        $(window).scrollTop($('#<?= @$_GET['type'] ?>').offset().top);
    });

    setTimeout(function() {
        $('#loadingcontent').modal('show');
    }, 1000);

    function linkproduct($link) {
        return window.location.href = $link;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const videoElement = document.getElementById('newsletter-video');
        const sourceElement = videoElement.querySelector('source');
        const baseUrl = '<?php echo BASE_URL; ?>'; // Pastikan BASE_URL tersedia

        function updateVideoSource() {
            const width = window.innerWidth;
            if (width <= 991) {
                sourceElement.src = `${baseUrl}assets/vid/bg-newsletter-mobile.mp4`;
            } else {
                sourceElement.src = `${baseUrl}assets/vid/bg-newsletter.mp4`;
            }
            videoElement.load(); // Muat ulang video
            videoElement.play(); // Mainkan ulang video
        }

        // Jalankan saat halaman dimuat
        updateVideoSource();

        // Jalankan saat ukuran layar berubah
        window.addEventListener('resize', updateVideoSource);
    });
</script>