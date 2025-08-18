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
<div class="content-page mb-5 withdraw-usdt">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12 px-2">
                <a href="<?= BASE_URL ?>hedgefund/withdraw" class="back-button" style="display: flex; align-items: center; justify-content: center; text-decoration: none; color: #FFFFFF; font-weight: bold;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="14" viewBox="0 0 11 14" fill="none" style="margin-right: 10px;">
                        <path d="M0 7L10.5 0.937822V13.0622L0 7Z" fill="#B48B3D" />
                    </svg>
                    BACK
                </a>
                <div class="withdraw-comission">
                    <?=get_balance()?>
                </div>
            </div>
            <div class="withdraw-options">
                <div class="withdraw-title">Withdraw Bank Option</div>
                <div class="text-center">
                    <a href="<?= BASE_URL ?>hedgefund/withdraw/usa_bank" class="transfer-btn mb-2 btn-lg w-50 d-inline-block">USA Bank</a>
                    <a href="<?= BASE_URL ?>hedgefund/withdraw/international_bank" class="transfer-btn mb-2 btn-lg w-50 d-inline-block">International Bank</a>
                </div>
            </div>
        </div>
    </div>
</div>