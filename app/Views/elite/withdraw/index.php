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
                <div class="withdraw-comission">

                    <div class="row referral-cards mb-4">
                        <div class="col-md-6">
                            <div class="custom-card left-card">
                                <div class="card-row card-top">
                                    Fund Balance
                                </div>
                                <div class="card-row card-bottom">
                                <?= '$ ' . @number_format($balance['fund']->usdt ?? 0, 0, '.', ',') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           <div class="withdraw-options">
                <div class="withdraw-title">Withdraw Option</div>
                <div class="text-center">
                    <a href="<?= BASE_URL ?>elite/withdraw/usdt" class="transfer-btn mb-2 btn-lg w-50 d-inline-block">USDT</a><br>
                    <a href="<?= BASE_URL ?>elite/withdraw/usdc" class="transfer-btn mb-2 btn-lg w-50 d-inline-block">USDC</a>
                    <a href="<?= BASE_URL ?>elite/withdraw/btc" class="transfer-btn mb-2 btn-lg w-50 d-inline-block">BTC</a>
                </div>
            </div>



            <div class="col-lg-12 dash-table-totalmember">
                <h4 class="text-white my-3 text-uppercase fw-bold">WITHDRAW HISTORY</h4>
                <table id="table_withdraw" class="table table-striped" style="width:100%">
                    <thead class="thead_totalmember">
                        <tr>
                            <th>DESCRIPTION</th>
                            <th>DATE</th>
                            <th>AMOUNT</th>
                            <th>ADDRESS</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>