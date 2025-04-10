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
                            <div class="card-row card-top">USDT BALANCE</div>
                            <div class="card-row card-bottom">
                                <?= '$ ' . @number_format($capital, 0, '.', ',') ?>
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
                            <div class="card-row card-top">BTC BALANCE</div>
                            <div class="card-row card-bottom">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40px" viewBox="0 0 384 512"><path d="M310.2 242.6c27.7-14.2 45.4-39.4 41.3-81.3-5.4-57.4-52.5-76.6-114.9-81.9V0h-48.5v77.2c-12.6 0-25.5 .3-38.4 .6V0h-48.5v79.4c-17.8 .5-38.6 .3-97.4 0v51.7c38.3-.7 58.4-3.1 63 21.4v217.4c-2.9 19.5-18.5 16.7-53.3 16.1L3.8 443.7c88.5 0 97.4 .3 97.4 .3V512h48.5v-67.1c13.2 .3 26.2 .3 38.4 .3V512h48.5v-68c81.3-4.4 135.6-24.9 142.9-101.5 5.7-61.4-23.3-88.9-69.3-99.9zM150.6 134.6c27.4 0 113.1-8.5 113.1 48.5 0 54.5-85.7 48.2-113.1 48.2v-96.7zm0 251.8V279.8c32.8 0 133.1-9.1 133.1 53.3 0 60.2-100.4 53.3-133.1 53.3z"/></svg>
                                <?= @number_format($capital, 4, '.', ',') ?>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end flex-row flex-wrap gap-2">
                            <a href="<?= BASE_URL ?>elite/withdraw/btc" class="btn-withdraw btn-lg">WITHDRAW</a>
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