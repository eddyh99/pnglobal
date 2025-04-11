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
                                        <h5 class="card-title text-black mb-0">USDT </h5>
                                        <h1 class="text-right text-black"><?= '$ ' . @number_format($balance['fund']->usdt ?? 0, 0, '.', ',') ?></h1>
                                    </div>
                                </div>
                                <div class="card rounded" style="width: 18rem;background-color: #bfa573;">
                                    <div class="card-body p-2">
                                        <h5 class="card-title text-black mb-0">BTC </h5>
                                        <h1 class="text-right text-black"><?= @number_format($balance['fund']->btc ?? 0, 0, '.', ',') ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between flex-row flex-wrap gap-2">
                            <a href="<?= BASE_URL ?>elite/deposit" class="btn-withdraw btn-lg me-1">DEPOSIT</a>
                            <a href="<?= BASE_URL ?>elite/withdraw" class="btn-withdraw btn-lg ms-1">WITHDRAW</a>
                        </div>
                    </div>

                    <!-- BTC -->
                    <div class="col-lg-6">
                        <div class="custom-card left-card mb-3">
                            <div class="card-row card-top text-center" style="font-weight: bold;">Unified Trading Wallet</div>
                            <div class="d-flex" style="gap: 1rem;">
                                <div class="card rounded" style="width: 18rem;background-color: #bfa573;">
                                    <div class="card-body p-2">
                                        <h5 class="card-title text-black mb-0">USDT </h5>
                                        <h1 class="text-right text-black"><?= '$ ' . @number_format($balance['trade']->usdt ?? 0, 0, '.', ',') ?></h1>
                                    </div>
                                </div>
                                <div class="card rounded" style="width: 18rem;background-color: #bfa573;">
                                    <div class="card-body p-2">
                                        <h5 class="card-title text-black mb-0">BTC </h5>
                                        <h1 class="text-right text-black"><?= @number_format($balance['trade']->btc ?? 0, 0, '.', ',') ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end flex-row flex-wrap gap-2">
                            <a href="<?= BASE_URL ?>elite/withdraw/transfer" class="btn-withdraw btn-lg">Transfer Balance</a>
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