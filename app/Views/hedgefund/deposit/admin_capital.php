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

<?php if (!empty(session('failed'))) {
    $failed = session('failed');
?>
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
<!-- Page Content -->
<div class="content-page mb-5">
    <div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow p-4" style="background-color: #2c2c2c; color: white; border-radius: 12px; width: 100%; max-width: 800px;">
            <h1 class="text-center mb-3">DEPOSIT</h1>
            <div class="elite-investment">
                <form action="<?= BASE_URL ?>hedgefund/deposit/add_deposit" method="POST">
                    <div class="row">
                        <div class="col-12">
                            <div class="min-capital-text">Amount</div>
                            <div class="min-capital-value"><input type="text" class="additional-capital-input form-control" id="Amount" name="amount"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="confirm-button">Confirm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
