<!-- Reset Password Start -->
<section class="forgot-password-page">
    <div class="container p-0" id="forgot-password-page-box">
        <div class="bg-white form-container forgot-password-container">
            <?php if (!empty(session('failed'))) { ?>
                <div id="failed-alert" class="alert alert-danger fade show position-absolute" style="top: 1rem; left: 1rem; width: 90%;" role="alert">
                    <div class="iq-alert-icon">
                        <i class="ri-information-line"></i>
                    </div>
                    <div class="iq-alert-text">
                        <?= session('failed') ?>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ri-close-line text-black"></i>
                    </button>
                </div>
            <?php } ?>
            <?php if (!empty(session('success'))) { ?>
                <div id="success-alert" class="alert alert-success fade show position-absolute" style="top: 1rem; left: 1rem; width: 90%;" role="alert">
                    <div class="iq-alert-icon">
                        <i class="ri-information-line"></i>
                    </div>
                    <div class="iq-alert-text">
                        <?= session('success') ?>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ri-close-line text-black"></i>
                    </button>
                </div>
            <?php } ?>
            <div class="forgot-password-page-data">
                <div class="forgot-password-form w-100">
                    <h1 class="mb-3 text-center text-black">Reset Password</h1>
                    <p class="text-center text-dark text-capitalize">Enter your email address to reset your password</p>
                    <form class="mt-4" id="forgotPasswordForm" action="<?= BASE_URL ?>member/auth/send_resetpassword">
                        <div class="form-group">
                            <label for="exampleInputEmail2">Email address</label>
                            <input type="email" class="form-control mb-0" name="email" id="email" placeholder="Enter email">
                        </div>
                        <div id="response-message" class="alert" style="display: none;"></div>
                        <div class="forgot-password-info text-center px-10">
                            <button type="submit" class="btn btn-primary mb-2 text-center">Reset</button>
                        </div>
                        <div class="register-section text-center pt-5">
                            Back to <a href="<?= BASE_URL ?>member/auth/login" style="color: #3D33FD; text-decoration: none;">Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <a href="<?= BASE_URL ?>"><img src="<?= BASE_URL ?>assets/img/logo.png" class="logo-signin" alt="logo"></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Reset Password End -->

<!-- <script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 5000);

    $("#forgotPasswordForm").on("submit", function(e) {
        e.preventDefault();
        var email = $("#email").val();
        var payload = {
            email: email
        };

        return alert("ASD");

        $.ajax({
            url: '<?= BASE_URL ?>auth/resend_token',
            type: "POST",
            data: payload,
            success: function(response) {
                if (response.code === 200) {
                    $(".alert").html('<div class="alert alert-success">' + response.message.text + '</div>');
                } else {
                    $(".alert").html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function(xhr, status, error) {
                $(".alert").html('<div class="alert alert-danger">Terjadi kesalahan: ' + error + '</div>');
            }
        });
    });
</script> -->