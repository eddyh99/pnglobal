<section class="elite-page">
    <div id="alert-container" class="show-failed" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>
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
            <div class="activation-page text-center">
                <h1 class="fw-bold">ACTIVATION</h1>
                <!-- <p>We have sent an activation code to your email.</p> -->
                <p>We have sent an activation code to your Whatsapp.</p>

                <form id="satoshi-otp-form" action="<?= BASE_URL ?>hedgefund/auth/reset_password_confirmation" method="POST" onsubmit="setFormData()">
                    <div id="otp" class="mt-3">
                        <input class="text-center form-control rounded" type="text" id="first" name="first" maxlength="1" autofocus />
                        <input class="text-center form-control rounded" type="text" id="second" name="second" maxlength="1" />
                        <input class="text-center form-control rounded" type="text" id="third" name="third" maxlength="1" />
                        <input class="text-center form-control rounded" type="text" id="fourth" name="fourth" maxlength="1" />
                        <input type="hidden" name="email" id="emailInput">
                        <input type="hidden" name="otp" id="otpInput">
                    </div>

                    <p class="mt-3">Enter the activation code in the column provided.</p>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <button id="resend" class="text-primary fw-bold btn" onclick="resendTokenWhatsapp('<?= $phone_number ?>')">RESEND</button>
                    <!-- <button id="resend" class="text-primary fw-bold btn" onclick="resendToken('<?= $emailuser ?>')">RESEND</button> -->
                     activation code
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
                    <h5 class="text-center text-capitalize mt-2">You will be redirected to initial capital</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function setFormData() {
        var otp = document.getElementById('first').value +
            document.getElementById('second').value +
            document.getElementById('third').value +
            document.getElementById('fourth').value;
        document.getElementById('otpInput').value = otp;

        document.getElementById('emailInput').value = "<?= @base64_decode($emailuser) ?>";
    }
</script>