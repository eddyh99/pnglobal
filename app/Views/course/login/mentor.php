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
    <div class="container">
        <div class="text-center mb-4" id="login">
            <h1 class="site-title"><span>PN</span> Online Course</h1>
            <p class="site-subtitle">Small Steps Today, Big Success Tomorrow</p>
        </div>

        <div class="sign-in-box" style="background-color: #101010;">
            <h2 class="text-center sign-in-text mt-5 text-white">SIGN IN</h2>
            <form action="<?= BASE_URL ?>course/auth/mentorlogin_proccess" method="POST">
                <div class="form-group mb-3 text-start">
                    <label for="email" class="form-label text-left text-white">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
                </div>

                <div class="form-group mb-3 text-start">
                    <label for="password" class="form-label text-left text-white">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                </div>

                <div class="d-flex justify-content-end mb-3">
                    <a href="<?= BASE_URL ?>course/auth/forgot_password" class="text-muted">Forgot Password?</a>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary text-black">Sign in</button>
                </div>

                <div class="text-center mt-3 dont-have-account text-white">
                Login as <a href="<?=BASE_URL?>course/login/member"><span style="color: #B48B3D;">Member</span></a>
                </div>
            </form>
        </div>

        <!-- Bottom button is inside container, ensuring it's below sign-in box -->
        <div class="bottom-button">
            <span class="d-block mb-2">Select a website to log in</span>
            <a href="#login" class="btn btn-dark"><span>ONLINE</span> COURSE</a>
            <a href="<?=BASE_URL?>member/auth/login" class="btn btn-dark mx-3"><span>HEDGE</span> FUND</a>
            <a href="<?=BASE_URL?>member/auth/login" class="btn btn-dark"><span>LUX</span> BTC</a>
        </div>
    </div>
</section>




