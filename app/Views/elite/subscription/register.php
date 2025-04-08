<?php if(!empty(session('failed'))) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session('failed')?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php }?>
<section class="elite-page">
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="site-title"><span>BTC ELITE</span> MANAGEMENT</h1>
            <p class="site-subtitle">Direct and Personalized Bitcoin Wallet Management.</p>
        </div>

        <div class="sign-in-box">
            <h2 class="text-center sign-in-text">REGISTER</h2>
            <form action="<?= BASE_URL ?>elite/auth/signup_process" method="POST">
                <div class="form-group mb-3 text-start">
                    <label for="email" class="fw-semibold">Email</label>
                    <input type="email" id="email" class="form-control" name="email" value="<?= set_value('email') ?>" required>
                </div>

                <div class="form-group-pass w-100 position-relative mt-3">
                    <label for="password" class="fw-semibold">Password</label>
                    <div class="wrapper-input position-relative">
                        <input type="password" name="pass" id="password" class="form-control pe-5" value="<?= set_value('pass') ?>" required>
                        <i class="icon-pass-login fa-solid fa-eye position-absolute end-0 top-50 translate-middle-y me-3" id="togglePassword" style="cursor: pointer;"></i>
                    </div>
                </div>
                
                <div class="form-group-pass w-100 position-relative mt-3">
                    <label for="confirmpassword" class="fw-semibold">Confirm Password</label>
                    <div class="wrapper-input position-relative">
                        <input type="password" name="cpass" id="password2" class="form-control pe-5" value="<?= set_value('cpass') ?>" required>
                        <i class="icon-pass-login fa-solid fa-eye position-absolute end-0 top-50 translate-middle-y me-3" id="togglePassword2" style="cursor: pointer;"></i>
                    </div>
                </div>

                <div class="form-group mb-3 text-start">
                    <div class="wrapper-input mt-3">
                        <label for="referral" class="fw-semibold">Referral Code</label>
                        <input type="text" id="referral" class="form-control" name="reff">
                    </div>
                </div>

                <input type="hidden" id="timezone" class="form-control" name="timezone" readonly value="<?= set_value('timezone') ?>">
                <input type="hidden" name="role" value="member">

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>

                <div class="text-center mt-3 dont-have-account">
                    Already have an account? <a href="login" class="register-link">Signin</a>
                </div>
            </form>
        </div>

        <!-- Bottom button is inside container, ensuring it's below sign-in box -->
        <div class="bottom-button">
            <a href="<?=BASE_URL?>member/auth/login" class="btn btn-dark"><span>LUX BTC</span> BROKER</a>
        </div>
    </div>
</section>

<div class="modal fade" id="loadingcontent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
