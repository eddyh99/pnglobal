<section class="elite-page">
<?php if (!empty(session('failed'))) { ?>
    <div id="danger-alert" class="alert alert-danger fade show position-absolute" 
     style="top: 20px; left: 50%; transform: translateX(-50%); width: 50%; z-index: 9999;" 
     role="alert">
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
    <div id="success-alert" class="alert alert-success fade show position-absolute" 
     style="top: 20px; left: 50%; transform: translateX(-50%); width: 50%; z-index: 9999;" 
     role="alert">
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
    <div class="text-center mb-4">
        <h1 class="site-title"><span>HEDGE</span> FUND</h1>
        <p class="site-subtitle">Direct and Personalized Bitcoin Wallet Management.</p>
    </div>

    <div class="sign-in-box">
        <h2 class="text-center sign-in-text mt-5">RESET PASSWORD</h2>
        <p class="text-center text-capitalize text-black">Enter your email address to reset your password</p>
        <form action="<?= BASE_URL ?>hedgefund/auth/send_resetpassword" method="POST">
            <div class="form-group mb-3 text-start">
                <label for="email" class="form-label text-left">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Reset</button>
            </div>

            <div class="text-center mt-3 dont-have-account">
                Back to <a href="<?=BASE_URL?>hedgefund/auth/login" class="register-link">LOGIN</a>
            </div>
        </form>
    </div>

    <!-- Bottom button is inside container, ensuring it's below sign-in box -->
    <div class="bottom-button">
        <a href="<?=BASE_URL?>auth" class="btn btn-dark"><span>MAIN MENU</span></a>
    </div>

</section>