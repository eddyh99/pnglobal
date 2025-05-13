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
                        <div class="col-lg-12 mb-2">
                            <div class="custom-card left-card mb-3">
                                <div class="card-row card-top text-center" style="font-weight: bold;">Funding Wallet</div>
                                <!-- <div class="card-row card-top">USDT</div>
                                <div class="card-row card-bottom">
                                    <?= '$ ' . @number_format($balance['fund']->usdt ?? 0, 0, '.', ',') ?>
                                </div> -->
    
                                <div class="d-flex" style="gap: 1rem;">
                                    <div class="card rounded" style="width: 18rem;background-color: #bfa573;">
                                        <div class="card-body p-2">
                                            <h5 class="card-title text-black mb-0 fw-bold">USDT </h5>
                                            <h2 class="text-right text-black"><?= '$ ' . @number_format($balance['fund']->usdt ?? 0, 0, '.', ',') ?></h2>
                                        </div>
                                    </div>
                                    <div class="card rounded" style="width: 18rem;background-color: #bfa573;">
                                        <div class="card-body p-2">
                                            <h5 class="card-title text-black mb-0 fw-bold">BTC</h5>
                                            <h2 class="text-right text-black">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" class="bi bi-currency-bitcoin" viewBox="0 0 30 30" id="Currency-Bitcoin--Streamline-Bootstrap" height="30" width="30">
                                                <path d="M10.3125 24.375v2.34375c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875h1.875a0.46875 0.46875 0 0 0 0.46875 -0.46875V24.375h0.9375v2.34375c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875h1.875a0.46875 0.46875 0 0 0 0.46875 -0.46875V24.375h0.1575c3.735 0 6.405 -1.936875 6.405 -5.2875 0 -2.81625 -1.8881249999999998 -4.355625 -4.09875 -4.575v-0.16499999999999998c1.8187499999999999 -0.45375 3.155625 -1.82625 3.155625 -4.10625C22.494374999999998 7.36875 20.338124999999998 5.625 17.0475 5.625H16.875V3.28125a0.46875 0.46875 0 0 0 -0.46875 -0.46875h-1.875a0.46875 0.46875 0 0 0 -0.46875 0.46875V5.625h-1.0743749999999999V3.28125a0.46875 0.46875 0 0 0 -0.46875 -0.46875H10.78125a0.46875 0.46875 0 0 0 -0.46875 0.46875V5.625l-3.74625 0.020624999999999998a0.46875 0.46875 0 0 0 -0.46875 0.46875v1.8543749999999999c0 0.256875 0.20625 0.46875 0.46499999999999997 0.46875l1.415625 -0.009375a1.40625 1.40625 0 0 1 1.396875 1.40625v10.321875a1.40625 1.40625 0 0 1 -1.40625 1.40625l-1.4025 0.020624999999999998a0.46875 0.46875 0 0 0 -0.46875 0.46875v1.875c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875zm2.675625 -15.961875h3.223125c1.69875 0 2.69625 0.93375 2.69625 2.46 0 1.633125 -1.078125 2.55375 -3.519375 2.55375h-2.4zm0 7.595625h3.45c2.131875 0 3.2925 1.0875 3.2925 2.8575 0 1.786875 -1.17375 2.71875 -4.04625 2.71875H12.988125z" stroke-width="1.875"></path>
                                            </svg>
                                                <?= @number_format($balance['fund']->btc ?? 0, 4, '.', ',') ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           <div class="withdraw-options">
                <div class="withdraw-title">Withdraw Option</div>
                <div class="text-center">
                    <a href="<?= BASE_URL ?>hedgefund/withdraw/usdt" class="transfer-btn mb-2 btn-lg w-50 d-inline-block">USDT</a><br>
                    <a href="<?= BASE_URL ?>hedgefund/withdraw/usdc" class="transfer-btn mb-2 btn-lg w-50 d-inline-block">USDC</a>
                    <a href="<?= BASE_URL ?>hedgefund/withdraw/btc" class="transfer-btn mb-2 btn-lg w-50 d-inline-block">BTC</a>
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