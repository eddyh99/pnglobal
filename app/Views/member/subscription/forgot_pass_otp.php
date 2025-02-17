    <section class="forgot-pass-otp">
        <div class="container-fluid p-0 m-0">
            <div class="row p-0 m-0">
                <div class="col-12 p-0 m-0">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <div class="position-relative otp-area w-100">
                            <?php if (!empty(session('failed'))) { ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>
                                        <?= session('failed') ?>
                                    </strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php } ?>
                            <form id="satoshi-otp-form" method="POST" class="p-3 text-center">
                                <h5>Check Your Email To Get OTP</h5>
                                <br>
                                <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                                    <input class="m-2 text-center form-control rounded" type="text" id="first" name="first" maxlength="1" />
                                    <input class="m-2 text-center form-control rounded" type="text" id="second" name="second" maxlength="1" />
                                    <input class="m-2 text-center form-control rounded" type="text" id="third" name="third" maxlength="1" />
                                    <input class="m-2 text-center form-control rounded" type="text" id="fourth" name="fourth" maxlength="1" />
                                </div>
                                <h6>Enter the activation code in the column provided.</h6>
                                <div class="mt-4">
                                    <button id="validateBtn" type="submit" class="btn btn-satoshi-price-register fs-6">CONFIRM</button>
                                </div>
                                <p class="my-5">
                                    <span id="resendotp" class="text-primary" style="cursor: pointer;">Resend</span> OTP
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Spinner for Loading register form -->
    <div class="modal fade" id="loadingcontent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="height: 50vh;">
                <div class="modal-body h-100" style="background-color: #C5A571;">
                    <div class="h-100 d-flex flex-column align-items-center justify-content-center">
                        <h2 class="text-center text-capitalize">Your account has been confirmed.</h2>
                        <h5 class="text-center text-capitalize mt-2">You will be redirected to the subscription page.</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>