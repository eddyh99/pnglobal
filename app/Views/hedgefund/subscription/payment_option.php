<!-- Page Content  -->
<section class="elite-page">
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="site-title"><span>HEDGE</span> FUND</h1>
            <p class="site-subtitle">Direct and Personalized Bitcoin Wallet Management.</p>
        </div>

         <!-- Sign-in box with centered buttons -->
        <div class="sign-in-box text-center p-4">
            <h1 class="fw-bold">PAYMENT OPTION</h1>

            <!-- Flexbox container for centering buttons -->
            <div class="d-flex flex-column justify-content-center align-items-center" style="height: 350px;">
                <a href="<?= BASE_URL ?>hedgefund/auth/usdt_payment" class="btn btn-primary btn-lg w-75">USDT</a>
                <a href="<?= BASE_URL ?>hedgefund/auth/usdc_payment" class="btn btn-primary btn-lg w-75 mt-3">USDC</a>
            </div>
        </div>
    </div>
</section>

<!-- Modal untuk menampilkan pesan sukses -->
<div class="modal fade" id="paymentSuccessModal" tabindex="-1" role="dialog" aria-labelledby="paymentSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered custom-modal-size" role="document">
        <div class="modal-content custom-modal-bg">
            <div class="modal-header">
                <h4 class="modal-title" id="paymentSuccessModalLabel">Payment Successful</h4>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="mb-4">
                        <i class="ri-checkbox-circle-line text-success" style="font-size: 4rem;"></i>
                    </div>
                    <p>Your payment is being processed and your account will be ready within 48 hours.</p>
                    <p>We will send you an email when your account is active.</p>
                </div>
            </div>
        </div>
    </div>
</div>