<?php if (!empty(session('success'))) { ?>
    <div class="alert alert-success fade show position-absolute" style="top: 1rem; right: 1rem; width: 30%; z-index: 99999;" role="alert">
        <div class="iq-alert-icon">
            <i class="ri-information-line"></i>
        </div>
        <div class="iq-alert-text text-black">
            <?= session('success') ?>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line text-black"></i>
        </button>
    </div>
<?php } ?>

<?php if (!empty(session('failed'))) { ?>
    <div class="alert alert-danger fade show position-absolute" style="top: 1rem; right: 1rem; width: 30%; z-index: 99999;" role="alert">
        <div class="iq-alert-icon">
            <i class="ri-information-line"></i>
        </div>
        <div class="iq-alert-text text-black">
            <?= session('failed') ?>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line text-black"></i>
        </button>
    </div>
<?php } ?>

<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12 px-2">
                <div class="payment-option-container">
                    <h1 class="payment-option-title usdt-title">USDC PAYMENT</h1>

                    <!-- USDT Payment Information -->
                    <div class="usdt-payment-info">
                        <div class="usdt-qr-container">
                            <div class="usdt-qr-code">
                                <img src="<?= BASE_URL ?>assets/img/qr-pnglobal.png" alt="USDT Payment QR Code" class="img-fluid">
                            </div>
                            <div class="usdt-payment-details">
                                <div class="usdt-wallet-address">
                                    <p class="address-label">PN Global USDT Wallet Address</p>
                                    <div class="address-value">
                                        <input type="text" class="form-control" value="TYQRBvjWcCY2kRLkQa1GhS9Dj1g5GZeXXX" id="wallet-address" readonly>
                                        <button class="copy-btn" onclick="copyToClipboard('wallet-address')">
                                            <i class="ri-file-copy-line"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="usdt-amount mt-3">
                                    <p class="amount-label">Network</p>
                                    <div class="amount-value">
                                        <input type="text" class="form-control" value="Blockchain" id="network" readonly>
                                    </div>
                                </div>
                                <div class="usdt-amount mt-3">
                                    <p class="amount-label">Amount to Pay</p>
                                    <div class="amount-value">
                                        <input type="text" class="form-control" value="100 USDT" id="payment-amount" readonly>
                                    </div>
                                </div>
                                <div class="payment-instructions mt-4">
                                    <ul class="instructions-list text-center">
                                        <li>After make payment please press "confirm" button</li>
                                    </ul>
                                </div>
                                <div class="payment-confirmation mt-4">
                                    <button class="confirm-payment-btn">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>