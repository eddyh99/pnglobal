<section class="forgot-pass-otp" style="background-color: black;">
    <div class="container-fluid p-0 m-0">
        <div class="row p-0 m-0">
            <div class="col-12 p-0 m-0">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <div class="position-relative container">
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
                                <h1 class="mb-3 text-center text-white">Reset Password</h1>
                                <p class="text-center text-white text-capitalize">Enter your email address to reset your password</p>
                                <form class="mt-4 text-white" action="<?= BASE_URL ?>course/auth/send_token">
                                    <div class="form-group text-center">
                                        <label class="text-white" for="exampleInputEmail2">Email address</label>
                                        <input type="email" class="form-control mb-0 w-50 mx-auto" name="email" id="email" placeholder="Enter email" required>
                                    </div>
                                    <div id="response-message" class="alert" style="display: none;"></div>
                                    <div class="forgot-password-info text-center px-10">
                                        <button type="submit" class="btn btn-primary mb-2 text-center">Reset</button>
                                    </div>
                                    <div class="register-section text-center pt-5">
                                        Back to <a href="<?= BASE_URL ?>course/auth/login/member" style="color: #3D33FD; text-decoration: none;">Login</a>
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