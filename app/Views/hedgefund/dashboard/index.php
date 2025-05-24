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
            <div class="col-lg-12">
                <!-- Top Row: Referral Card -->
                 <?php if($isreferral): ?>
                <div class="row mb-4">
                    <div class="col-lg-6">
                        <div class="referral-card">
                            <div class="referral-link text-white">
                                Referral link:
                                <a href="https://pnglobalinternational.com/<?= $refcode ?>" target="_blank">
                                    https://pnglobalinternational.com/<?= $refcode ?>
                                </a>
                            </div>
                            <div class="referral-qr">
                                <!-- icons... -->
                                <p>Show QR Code</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif ?>

                <!-- Second Row: USDT & BTC Cards Side by Side -->
                <div class="row mb-4">
                    <!-- USDT -->
                    <div class="col-lg-6 mb-2">
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
                                        <h2 class="text-right text-black"><?= '$ ' . $balance['fund']->usdt ?? 0 ?></h2>
                                    </div>
                                </div>
                                <div class="card rounded" style="width: 18rem;background-color: #bfa573;">
                                    <div class="card-body p-2">
                                        <h5 class="card-title text-black mb-0 fw-bold">BTC</h5>
                                        <h2 class="text-right text-black">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" class="bi bi-currency-bitcoin" viewBox="0 0 30 30" id="Currency-Bitcoin--Streamline-Bootstrap" height="30" width="30">
                                                <path d="M10.3125 24.375v2.34375c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875h1.875a0.46875 0.46875 0 0 0 0.46875 -0.46875V24.375h0.9375v2.34375c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875h1.875a0.46875 0.46875 0 0 0 0.46875 -0.46875V24.375h0.1575c3.735 0 6.405 -1.936875 6.405 -5.2875 0 -2.81625 -1.8881249999999998 -4.355625 -4.09875 -4.575v-0.16499999999999998c1.8187499999999999 -0.45375 3.155625 -1.82625 3.155625 -4.10625C22.494374999999998 7.36875 20.338124999999998 5.625 17.0475 5.625H16.875V3.28125a0.46875 0.46875 0 0 0 -0.46875 -0.46875h-1.875a0.46875 0.46875 0 0 0 -0.46875 0.46875V5.625h-1.0743749999999999V3.28125a0.46875 0.46875 0 0 0 -0.46875 -0.46875H10.78125a0.46875 0.46875 0 0 0 -0.46875 0.46875V5.625l-3.74625 0.020624999999999998a0.46875 0.46875 0 0 0 -0.46875 0.46875v1.8543749999999999c0 0.256875 0.20625 0.46875 0.46499999999999997 0.46875l1.415625 -0.009375a1.40625 1.40625 0 0 1 1.396875 1.40625v10.321875a1.40625 1.40625 0 0 1 -1.40625 1.40625l-1.4025 0.020624999999999998a0.46875 0.46875 0 0 0 -0.46875 0.46875v1.875c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875zm2.675625 -15.961875h3.223125c1.69875 0 2.69625 0.93375 2.69625 2.46 0 1.633125 -1.078125 2.55375 -3.519375 2.55375h-2.4zm0 7.595625h3.45c2.131875 0 3.2925 1.0875 3.2925 2.8575 0 1.786875 -1.17375 2.71875 -4.04625 2.71875H12.988125z" stroke-width="1.875"></path>
                                            </svg>
                                            <?= $balance['fund']->btc ?? 0 ?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start flex-row flex-wrap gap-2">
                            <a href="<?= BASE_URL ?>hedgefund/deposit" class="btn-withdraw btn-lg">DEPOSIT</a>
                        </div>
                    </div>

                    <!-- BTC -->
                    <div class="col-lg-6">
                        <div class="custom-card left-card mb-3">
                            <div class="card-row card-top text-center" style="font-weight: bold;">Unified Trading Wallet</div>
                            <div class="d-flex" style="gap: 1rem;">
                                <div class="card rounded" style="width: 18rem;background-color: #bfa573;">
                                    <div class="card-body p-2">
                                        <h5 class="card-title text-black mb-0 fw-bold">USDT </h5>
                                        <h2 class="text-right text-black"><?= '$ ' . $balance['trade']->usdt ?? 0 ?></h2>
                                    </div>
                                </div>
                                <div class="card rounded" style="width: 18rem;background-color: #bfa573;">
                                    <div class="card-body p-2">
                                        <h5 class="card-title text-black mb-0 fw-bold">BTC </h5>
                                        <h2 class="text-right text-black">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" class="bi bi-currency-bitcoin" viewBox="0 0 30 30" id="Currency-Bitcoin--Streamline-Bootstrap" height="30" width="30">
                                                <path d="M10.3125 24.375v2.34375c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875h1.875a0.46875 0.46875 0 0 0 0.46875 -0.46875V24.375h0.9375v2.34375c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875h1.875a0.46875 0.46875 0 0 0 0.46875 -0.46875V24.375h0.1575c3.735 0 6.405 -1.936875 6.405 -5.2875 0 -2.81625 -1.8881249999999998 -4.355625 -4.09875 -4.575v-0.16499999999999998c1.8187499999999999 -0.45375 3.155625 -1.82625 3.155625 -4.10625C22.494374999999998 7.36875 20.338124999999998 5.625 17.0475 5.625H16.875V3.28125a0.46875 0.46875 0 0 0 -0.46875 -0.46875h-1.875a0.46875 0.46875 0 0 0 -0.46875 0.46875V5.625h-1.0743749999999999V3.28125a0.46875 0.46875 0 0 0 -0.46875 -0.46875H10.78125a0.46875 0.46875 0 0 0 -0.46875 0.46875V5.625l-3.74625 0.020624999999999998a0.46875 0.46875 0 0 0 -0.46875 0.46875v1.8543749999999999c0 0.256875 0.20625 0.46875 0.46499999999999997 0.46875l1.415625 -0.009375a1.40625 1.40625 0 0 1 1.396875 1.40625v10.321875a1.40625 1.40625 0 0 1 -1.40625 1.40625l-1.4025 0.020624999999999998a0.46875 0.46875 0 0 0 -0.46875 0.46875v1.875c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875zm2.675625 -15.961875h3.223125c1.69875 0 2.69625 0.93375 2.69625 2.46 0 1.633125 -1.078125 2.55375 -3.519375 2.55375h-2.4zm0 7.595625h3.45c2.131875 0 3.2925 1.0875 3.2925 2.8575 0 1.786875 -1.17375 2.71875 -4.04625 2.71875H12.988125z" stroke-width="1.875"></path>
                                            </svg>
                                            <?= $balance['trade']->btc ?? 0 ?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end flex-row flex-wrap gap-2">
                            <a href="<?= BASE_URL ?>hedgefund/withdraw/transfer" class="btn-withdraw btn-lg" style="max-width:350px !important">Transfer to Funds Wallet</a>
                        </div>
                    </div>


                    <!-- Binace Card -->
                    <!-- <div class="binance-fullcard">
                    <div class="binance-fullcard-header">
                        Connect Binance API
                    </div>
                    <div class="binance-detailcard">
                        <div class="label">
                            API Key
                        </div>
                        <div class="value">
                            adsjJN945wkngsflkn
                        </div>
                        <div class="label">
                            API Secret
                        </div>
                        <div class="value">
                            adsjJN945wadsjJN945wkngsflkn
                        </div>
                    </div>
                    <div class="binance-fullcard-footer">
                        <button class="edit-btn">Edit</button>
                    </div>
                </div> -->
                    <!-- Tombol di luar binance-fullcard -->
                    <!-- <div class="binance-button-row">
                    <button class="get-api-btn">How to get API?</button>
                    <button class="support-btn">Contact Support</button>
                </div> -->
                    <div class="col-lg-12 mt-3 dash-table-totalmember">
                        <h4 class="text-white my-3 text-uppercase fw-bold">Trade History</h4>
                        <table id="table_tradehistory" class="table table-striped" style="width:100%">
                            <thead class="thead_totalmember">
                                <tr>
                                    <th>DATE</th>
                                    <th>AMOUNT USDT</th>
                                    <th>BTC PRICE</th>
                                    <th>AMOUNT BTC</th>
                                    <th>POSITION</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>