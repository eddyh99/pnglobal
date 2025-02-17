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
            <div class="sign-in-page-data">
                <div class="sign-in-from w-100 m-auto">
                    <h1 class="mb-3 text-center text-black">Reset Password</h1>
                    <p class="text-center text-dark text-capitalize">Masukkan alamat email Anda untuk mereset password.</p>
                    <form action="<?= BASE_URL ?>auth/send_resetpassword" method="POST" class="mt-4">
                        <div class="form-group">
                            <label for="exampleInputEmail2">Email address</label>
                            <input type="email" class="form-control mb-0" name="email" id="exampleInputEmail2" placeholder="Enter email">
                        </div>
                        <div class="sign-info">
                            <button type="submit" class="btn btn-primary mb-2">Reset</button>
                        </div>
                        <div class="register-section text-center pt-5">
                            Back to <a href="<?= BASE_URL ?>auth/login" style="color: #3D33FD; text-decoration: none;">Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <a href="<?= BASE_URL ?>"><img src="<?= BASE_URL ?>assets/img/logo-satoshi.png" class="logo-signin" alt="logo"></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Reset Password End -->