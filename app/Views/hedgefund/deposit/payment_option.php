<!-- Page Content -->
<div class="content-page mb-5">
    <div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow p-4" style="background-color: #2c2c2c; color: white; border-radius: 12px; width: 100%; max-width: 500px;">
            <h1 class="text-center fw-bold mb-3">PAYMENT OPTION</h1>
            <div class="d-flex flex-column justify-content-center align-items-center" style="height: 350px;">
                <a href="<?= BASE_URL ?>hedgefund/deposit/usdt_payment" class="btn btn-primary btn-lg w-75 btn-withdraw">USDT</a>
                <a href="<?= BASE_URL ?>hedgefund/deposit/usdc_payment" class="btn btn-primary btn-lg w-75 btn-withdraw mt-3">USDC</a>
            </div>
        </div>
    </div>
</div>

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