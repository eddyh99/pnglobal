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
                                <a href="https://pnglobalinternational.com/hf/<?= $refcode ?>" target="_blank">
                                    https://pnglobalinternational.com/hf/<?= $refcode ?>
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
                        <div class="custom-card left-card" id="card-referral">
                            <div class="card-row card-top">
                                Total Referral
                            </div>
                            <div class="card-row card-bottom">
                                Loading...
                            </div>
                        </div>
                    </div>

                    <!-- BTC -->
                    <div class="col-lg-6">
                        <div class="custom-card left-card" id="card-commission">
                            <div class="card-row card-top">
                                USDT Comission
                            </div>
                            <div class="card-row card-bottom">
                                Loading...
                            </div>
                        </div>

                        <div class="d-flex justify-content-between flex-row flex-wrap gap-2">
                            <a href="<?= BASE_URL ?>hedgefund/withdraw/transfer/commission_trade" class="btn-withdraw btn-lg ms-1" style="min-width:250px !important">To Trade Wallet</a>
                            <a href="<?= BASE_URL ?>hedgefund/withdraw/transfer" class="btn-withdraw btn-lg ms-1" style="min-width:250px !important">To Funds Wallet</a>
                        </div>
                    </div>

                    <div class="col-lg-12 mt-3 dash-table-totalmember">

                        <div id="commission-content">
                            <h4 class="text-white my-3 text-uppercase fw-bold">Commission</h4>
                            <table id="table_commission" class="table table-striped" style="width:100%">
                                <thead class="thead_referralmember">
                                    <tr>
                                    <th>Date</th>
                                        <th>Description</th>
                                        <th>COMISSION</th>
                                        <!-- <th>SUBSCRIPTION</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <!-- <th>Total</th>
                                        <th></th> -->
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-12 mt-3 dash-table-totalmember">

                        <div id="referral-content" style="display: none;">
                            <h4 class="text-white my-3 text-uppercase fw-bold">Referral</h4>
                            <table id="table_referralmember" class="table table-striped" style="width:100%">
                            <thead class="thead_referralmember">
                                <tr>
                                    <th>EMAIL</th>
                                    <th>STATUS</th>
                                    <th>COMISSION</th>
                                    <!-- <th>SUBSCRIPTION</th> -->
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>