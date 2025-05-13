<section class="forgot-pass-otp" style="background-color: black;">
    <div class="container-fluid p-0 m-0">
        <div class="row p-0 m-0">
            <div class="col-12 p-0 m-0">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <div class="position-relative container bg-white rounded">
                        <?php if (!empty(session('failed'))) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>
                                    <?= session('failed') ?>
                                </strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="ri-close-line text-black"></i>
                                </button>
                            </div>
                        <?php } ?>
                        <div class="forgot-password-page-data">
                            <div class="forgot-password-form w-100">
                                <h1 class="mb-3 text-center text-black">Reset Password</h1>
                                <p class="text-center text-capitalize text-black">Enter your email address to reset your password</p>
                                <form class="mt-4" action="#">
                                    <div class="form-group text-center">
                                        <label for="exampleInputEmail2"><b>Email address</b></label>
                                        <input type="email" class="form-control mb-0 w-50 mx-auto" style="background-color: #d6d6d6;" name="email" id="email" placeholder="Enter email" required>
                                    </div>
                                    <div id="response-message" class="alert" style="display: none;"></div>
                                    <div class="forgot-password-info text-center px-10">
                                        <button type="submit" class="btn btn-primary mb-2 text-center">Reset</button>
                                    </div>
                                    <div class="register-section text-center text-black py-4">
                                        Back to <a href="<?= BASE_URL ?>hedgefund/auth/login" style="color: #3D33FD; text-decoration: none;">Login</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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