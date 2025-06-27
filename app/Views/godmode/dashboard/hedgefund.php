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

        <!-- elite btc -->
        <div id="elite-btc" class="tab-content active">
            <div class="row content-body">
                <div class="w-100 d-flex justify-content-end mb-2 pe-5">
                    <a href="<?=BASE_URL?>godmode/hedge/profit" class="btn btn-primary">
                        <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 18L20 18" stroke="#000000" stroke-width="2" stroke-linecap="round"/>
                        <path d="M4 12L20 12" stroke="#000000" stroke-width="2" stroke-linecap="round"/>
                        <path d="M4 6L20 6" stroke="#000000" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </a>
                </div>

                <div class="col-lg-12 px-2">
                    <!-- balance fund & trade -->
                    <div class="container-fluid">
                        <div class="row dash-statistics">
                            <div class="col-12 col-sm-6 col-lg-3 mb-2">
                                <a class="d-block h-75">
                                    <div class="iq-card h-100">
                                        <div class="iq-card-body">
                                            <div class="d-flex flex-column justify-content-center align-items-start">
                                                <h5 class="text-black">Funding Wallet</h5>
                                                <div class="mt-3 w-100 d-flex justify-content-end">
                                                    <h2 id="fund_balance" class="text-right text-black">Loading...</h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                    
                            <div class="col-12 col-sm-6 col-lg-3 mb-2">
                                <a class="d-block h-75">
                                    <div class="iq-card h-100">
                                        <div class="iq-card-body">
                                            <div class="d-flex flex-column justify-content-center align-items-start">
                                                <h5 class="text-black">Trade Wallet</h5>
                                                <div class="mt-3 w-100 d-flex justify-content-end">
                                                    <h2 id="trade_balance" class="text-right text-black">Loading...</h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                    
                            <div class="col-12 col-sm-6 col-lg-3 mb-2">
                                <a class="d-block h-75">
                                    <div class="iq-card h-100">
                                        <div class="iq-card-body">
                                            <div class="d-flex flex-column justify-content-center align-items-start">
                                                <h5 class="text-black">Comission</h5>
                                                <div class="mt-3 w-100 d-flex justify-content-end">
                                                    <h2 id="comission" class="text-right text-black">Loading...</h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 mb-2">
                                <a href="#" class="d-block h-75">
                                    <div class="iq-card h-100">
                                        <div class="iq-card-body">
                                            <div class="d-flex flex-column justify-content-center align-items-start">
                                                <h5 class="text-black">Binance USDT</h5>
                                                <div class="mt-3 w-100 d-flex justify-content-end">
                                                    <h2 id="binance" class="text-right text-black">Loading...</h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="container-fluid">
                        <div class="row dash-statistics">
                            <div class="col-12 col-sm-6 col-lg-3 mb-2">
                                <a href="<?= BASE_URL ?>godmode/dashboard/hedgefund" class="d-block h-75">
                                    <div class="iq-card h-100">
                                        <div class="iq-card-body">
                                            <div class="d-flex flex-column justify-content-center align-items-start">
                                                <h5 class="text-black">Total Member</h5>
                                                <div class="mt-3 w-100 d-flex justify-content-end">
                                                    <h1 class="text-black fw-bold"><?= @$totalmemberelite ?></h1>
                                                </div>
                                            </div>
                                            <div class="<?= ((base64_decode(@$_GET["type"]) == "free_member" || base64_decode(@$_GET["type"]) == "referral_member") ? "disable" : "active") ?>"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                    
                            <div class="col-12 col-sm-6 col-lg-3 mb-2">
                                <a href="<?= BASE_URL ?>godmode/hedge" class="d-block h-75">
                                    <div class="iq-card h-100">
                                        <div class="iq-card-body">
                                            <div class="d-flex flex-column justify-content-center align-items-start">
                                                <h5 class="text-black">Active Member</h5>
                                                <div class="mt-3 w-100 d-flex justify-content-end">
                                                    <h1 class="text-black fw-bold"><?= @$subscriberelite ?></h1>
                                                </div>
                                            </div>
                                            <div class="<?= ((base64_decode(@$_GET["type"]) == "referral_member") ? "active" : "disable") ?>"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                    
                            <div class="col-12 col-sm-6 col-lg-3 mb-2">
                                <a href="#" class="d-block h-75">
                                    <div class="iq-card h-100">
                                        <div class="iq-card-body">
                                            <div class="d-flex flex-column justify-content-center align-items-start">
                                                <h5 class="text-black">Referral</h5>
                                                <div class="mt-3 w-100 d-flex justify-content-end">
                                                    <h1 class="text-black fw-bold"><?= @$referralelite ?></h1>
                                                </div>
                                            </div>
                                            <div class="disable"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                    
                            <div class="col-12 col-sm-6 col-lg-3 mb-2">
                                <a href="#" class="d-block h-75">
                                    <div class="iq-card h-100">
                                        <div class="iq-card-body">
                                            <div class="d-flex flex-column justify-content-center align-items-start">
                                                <h5 class="text-black">Signal Sent</h5>
                                                <div class="mt-3 w-100 d-flex justify-content-end">
                                                    <h1 class="text-black fw-bold"><?= @$signalelite ?></h1>
                                                </div>
                                            </div>
                                            <div class="disable"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 dash-table-totalmember">
                    <h4 class="text-white my-3 text-uppercase fw-bold">Total Member</h4>
                    <table id="table_totalmember_elite" class="table table-striped" style="width:100%">
                        <thead class="thead_totalmember">
                            <tr>
                                <th style="width:15%">EMAIL</th>
                                <th style="font-size: 11px;white-space: nowrap;">REF CODE</th>
                                <!-- <th>REG. DATE</th> -->
                                <th>STATUS</th>
                                <!-- <th>SUBSCRIPTION</th> -->
                                <th>REFERRAL</th>
                                <th>Fund</th>
                                <th>Trade</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <th colspan="4">Total</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
        <!-- end -->

    </div>
</div>