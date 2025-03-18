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

        // Handle newsletter form submission
        const newsletterForm = document.querySelector('.newsletter-form');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const emailInput = this.querySelector('input[type="email"]');
                const email = emailInput.value;
                const submitButton = this.querySelector('button[type="submit"]');
                const formContainer = this.closest('.newsletter-card');
                const originalContent = formContainer.innerHTML;

                // Disable button and show loading state
                submitButton.disabled = true;
                submitButton.innerHTML = 'SENDING...';

                // Send AJAX request
                fetch(`${baseUrl}homepage/subscribe_newsletter`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `email=${encodeURIComponent(email)}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Replace form with success message
                            formContainer.innerHTML = `
                                <p class="card-description">
                                    Thank you for join our newsletter
                                </p>
                            `;

                            // Reset form after 3 seconds
                            setTimeout(() => {
                                formContainer.innerHTML = originalContent;
                                emailInput.value = '';
                            }, 3000);
                        } else {
                            // Show error message
                            alert(data.message || 'Failed to subscribe. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again later.');
                    })
                    .finally(() => {
                        // Re-enable button and restore original text
                        submitButton.disabled = false;
                        submitButton.innerHTML = 'SUBSCRIBE';
                    });
            });
        }
    });
</script>