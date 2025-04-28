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
                    <h1 class="mb-3 text-center text-black">Create Password</h1>
                    <p class="text-center text-dark text-capitalize">Create your new password</p>
                    <form action="<?= BASE_URL ?>course/auth/update_password" method="POST" class="mt-4" id="forgotPasswordForm">
                        <input type="hidden" name="email" value="<?= $email ?>">
                        <input type="hidden" name="otp" value="<?= $otp ?>">
                        <div class="form-group">
                            <label for="exampleInputEmail2">New Password</label>
                            <input type="password" class="form-control mb-0" name="password" id="password" placeholder="Enter new password">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail2">Confirm Password</label>
                            <input type="password" class="form-control mb-0" name="confirm_password" id="confirm_password" placeholder="Confirm new password">
                        </div>
                        <div class="forgot-password-info text-center px-10">
                            <button type="submit" class="btn btn-primary mb-2 text-center">Submit</button>
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