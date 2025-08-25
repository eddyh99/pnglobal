<?php if (!empty(session('failed'))) { ?>
    <div id="failed-alert" class="alert alert-danger fade show d-flex align-items-center position-fixed"
        style="top: 1rem; right: 1rem; width: 100%; max-width: 350px; padding: 1rem; border-radius: 8px; z-index: 1050; border: 1px solid #f5c6cb;">
        <div class="iq-alert-icon" style="margin-right: 10px; font-size: 1.5rem; color: #dc3545;">
            <i class="ri-close-circle-line"></i>
        </div>
        <div class="iq-alert-text" style="flex-grow: 1; color: #dc3545; font-weight: 600;">
            <?= session('failed') ?>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"
            style="border: none; background: transparent; font-size: 1.2rem; cursor: pointer; color: #dc3545;">
            &times;
        </button>
    </div>
<?php } ?>

<?php if (!empty(session('success'))) { ?>
    <div id="success-alert" class="alert alert-success fade show d-flex align-items-center position-fixed"
        style="top: 1rem; right: 1rem; width: 100%; max-width: 350px; padding: 1rem; border-radius: 8px; z-index: 1050; border: 1px solid #b8e2b8;">
        <div class="iq-alert-icon" style="margin-right: 10px; font-size: 1.5rem; color: #28a745;">
            <i class="ri-checkbox-circle-line"></i>
        </div>
        <div class="iq-alert-text" style="flex-grow: 1; color: #28a745; font-weight: 600;">
            <?= session('success') ?>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"
            style="border: none; background: transparent; font-size: 1.2rem; cursor: pointer; color: #28a745;">
            &times;
        </button>
    </div>
<?php } ?>
<section class="elite-page">
    <div class="text-center mb-4">
        <h1 class="site-title"><span>HEDGE</span> FUND</h1>
        <p class="site-subtitle">Direct and Personalized Bitcoin Wallet Management.</p>
    </div>

    <div class="sign-in-box">
        <h2 class="text-center sign-in-text mt-5">LOG IN</h2>
        <form action="<?= BASE_URL ?>hedgefund/auth/postLogin" method="POST">
            <div class="form-group mb-3 text-start">
                <label for="email" class="form-label text-left">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
            </div>
            <div>
                <label for="password" class="form-label text-left">Password</label>
                <div class="wrapper-input position-relative">
                    <input type="password" name="password" id="password" class="form-control pe-5" placeholder="Password">
                    <i class="icon-pass-login fa-solid fa-eye position-absolute end-0 top-50 translate-middle-y me-3" id="togglePassword" style="cursor: pointer;"></i>
                </div>
            </div>

            <div class="d-flex justify-content-end mb-3">
                <a href="<?= BASE_URL ?>hedgefund/auth/forgot_password" class="text-muted">Forgot Password?</a>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Log In</button>
            </div>

            <div class="text-center mt-3 dont-have-account">
                Don't have an account? <a href="<?= BASE_URL ?>hedgefund/auth/register" class="register-link">REGISTER</a>
            </div>
        </form>
    </div>

    <!-- Bottom button is inside container, ensuring it's below sign-in box -->
    <div class="bottom-button">
        <a href="<?= BASE_URL ?>auth" class="btn btn-dark"><span>MAIN MENU</span></a>
    </div>

</section>