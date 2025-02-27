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
                    <h1 class="payment-option-title">PAYMENT OPTION</h1>
                    <div class="payment-buttons">
                        <button class="payment-btn" onclick="window.location.href='<?= BASE_URL ?>member/membership/card_payment'">CARD</button>
                        <button class="payment-btn" onclick="window.location.href='<?= BASE_URL ?>member/membership/usdt_payment'">USDT</button>
                        <button class="payment-btn" onclick="window.location.href='<?= BASE_URL ?>member/membership/usdc_payment'">USDC</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>