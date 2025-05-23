<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12 px-2">
                <div class="payment-option-container">
                    <h1 class="payment-option-title">PAYMENT OPTION</h1>
                    <div class="payment-buttons">
                        <button class="payment-btn" onclick="window.location.href='<?= BASE_URL ?>member/membership/usdt_payment'">USDT</button>
                        <button class="payment-btn" onclick="window.location.href='<?= BASE_URL ?>member/membership/usdc_payment'">USDC</button>
                    </div>
                </div>
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
                    <p>Your payment is being processed</p>
                </div>
            </div>
        </div>
    </div>
</div>