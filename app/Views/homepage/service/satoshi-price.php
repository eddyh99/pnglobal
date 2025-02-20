<!-- Start of Register Form -->
<section class="main-section-register">
    <section id="register" class="satoshi-register">
        <div class="container">
            <div class="row">
                <div class="col-10 mx-auto">
                    <h1 class="fw-bold text-uppercase text-center mb-5">
                        PN global REGISTER FORM
                    </h1>
                    <?php if (!empty(session('failed'))) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>
                                <?= session('failed') ?>
                            </strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>
                </div>
                <form id="satoshi-register-form" action="<?= BASE_URL ?>homepage/register_process" method="post">
                    <div class="col-10 mx-auto bg-satoshi-register">
                        <div class="register-form">
                            <label for="email" class="fw-semibold">Email</label>
                            <input type="email" id="email" class="form-control" name="email" value="<?= set_value('email') ?>">
                        </div>
                        <div class="form-group-pass w-100 position-relative">
                            <div class="wrapper-input mt-3">
                                <label for="password" class="fw-semibold">Password</label> <br>
                                <input type="password" name="pass" id="password" class="form-control" name="pass" value="<?= set_value('pass') ?>">
                            </div>
                            <i class="icon-pass-login fa-solid fa-eye" id="togglePassword"></i>
                        </div>
                        <div class="form-group-pass w-100 position-relative">
                            <div class="wrapper-input mt-3">
                                <label for="confirmpassword" class="fw-semibold">Confirm Password</label> <br>
                                <input type="password" name="cpass" id="password2" class="form-control" name="cpass" value="<?= set_value('cpass') ?>">
                            </div>
                            <i class="icon-pass-login fa-solid fa-eye" id="togglePassword2"></i>
                        </div>
                        <div class="register-form mt-3">
                            <label for="timezone" class="fw-semibold">Timezone</label>
                            <input type="text" id="timezone" class="form-control" name="timezone" readonly value="<?= set_value('timezone') ?>">
                        </div>
                        <div class="register-form mt-3">
                            <label for="referral" class="fw-semibold">Referral Code</label>
                            <input type="text" id="referral" class="form-control" name="reff">
                        </div>
                        <div class="register-form mt-3">
                            <input type="hidden" name="role" value="member">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-satoshi-price-register">SIGNUP</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- End of Register Form -->

    <!-- Spinner for Loading register form -->
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
</section>