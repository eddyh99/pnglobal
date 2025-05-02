<?php if (!empty(session('failed'))) { ?>
    <div id="failed-alert" class="alert alert-danger fade show position-absolute" style="top: 1rem;" role="alert">
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
    <div id="success-alert" class="alert alert-success fade show position-absolute" style="top: 1rem;" role="alert">
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
<div class="container-fluid min-vh-100 d-flex flex-column justify-content-center align-items-center" style="background-color: black;">
    <div class="w-100" style="max-width: 400px;">
        <h3 class="text-center mb-4">Create Password</h3>
        <form action="<?= BASE_URL ?>course/auth/update_password" method="POST">
            <div class="mb-3">
                <input type="hidden" name="email" value="<?= $email ?>">
                <input type="hidden" name="otp" value="<?= $otp ?>">
                <label for="password" class="form-label text-white">New Password</label>
                <input type="password" class="form-control border-primary" name="password" id="password">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label text-white">Confirm Password</label>
                <input type="password" class="form-control border-primary" name="confirm_password" id="confirm_password">
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary text-black">Confirm</button>
            </div>
        </form>
    </div>
</div>