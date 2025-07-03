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
                <a class="text-white" href="<?= BASE_URL ?>godmode/dashboard/hedgefund">BACK</a>
            </div>
            <div class="col-lg-10 mx-auto">
                <h4 class="text-center"><?= $email; ?></h4>

                <!-- Detail -->
                <div class="dash-detailmember">
                    <div class="header">Detail</div>
                    <!-- Membership Status -->
                    <div class="label">Membership Status</div>
                    <div class="value">
                        Normal Member
                    </div>

                    <!-- Registration date -->
                    <div class="label">Registration date</div>
                    <div class="value">
                        <?php
                        $dateString = $member->start_date ?? '';

                        if ($dateString) {
                            $date = new DateTime($dateString);
                            $formattedDate = $date->format('d F Y');
                            echo $formattedDate;
                        } else {
                            echo 'N/A';
                        }
                        ?>
                    </div>

                    <!-- Subscription Status -->
                    <div class="label">Subscription Status</div>
                    <div class="value">
                        <?php
                        echo $member->membership_status ?? 'N/A';
                        ?>
                    </div>

                    <!-- Subscription Plan -->
                    <div class="label">Subscription Plan</div>
                    <div class="value">
                        <?php
                        echo $member->subscription_plan ?? 'N/A';
                        ?>
                    </div>

                    <!-- Referral Code -->
                    <div class="label">Referral Code</div>
                    <div class="value">
                        <?php
                        $refcode = $member->refcode;
                        echo !empty($refcode) ? $refcode : '-';
                        ?>
                    </div>


                    <!-- Referral Link -->
                    <div class="label">Referral Link</div>
                    <div class="d-flex flex-row justify-content-start text-white">
                        <?php if (!empty($member->refcode)): ?>
                            <input class="me-2" type="text" name="" id="refcode" class="form-control"
                                value="<?php
                                        echo "https://pnglobalinternational.com/hf/" . ($member->refcode ?? '');
                                        ?>"
                                readonly style="min-width: 28ch;">
                            <a class="btn btn-copy me-2" id="btnref">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.16675 12.5C3.39018 12.5 3.00189 12.5 2.69561 12.3731C2.28723 12.204 1.96277 11.8795 1.79362 11.4711C1.66675 11.1649 1.66675 10.7766 1.66675 10V4.33333C1.66675 3.39991 1.66675 2.9332 1.8484 2.57668C2.00819 2.26308 2.26316 2.00811 2.57676 1.84832C2.93328 1.66666 3.39999 1.66666 4.33341 1.66666H10.0001C10.7767 1.66666 11.1649 1.66666 11.4712 1.79353C11.8796 1.96269 12.2041 2.28714 12.3732 2.69553C12.5001 3.00181 12.5001 3.39009 12.5001 4.16666M10.1667 18.3333H15.6667C16.6002 18.3333 17.0669 18.3333 17.4234 18.1517C17.737 17.9919 17.992 17.7369 18.1518 17.4233C18.3334 17.0668 18.3334 16.6001 18.3334 15.6667V10.1667C18.3334 9.23324 18.3334 8.76653 18.1518 8.41001C17.992 8.09641 17.737 7.84144 17.4234 7.68165C17.0669 7.5 16.6002 7.5 15.6667 7.5H10.1667C9.23333 7.5 8.76662 7.5 8.4101 7.68165C8.09649 7.84144 7.84153 8.09641 7.68174 8.41001C7.50008 8.76653 7.50008 9.23324 7.50008 10.1667V15.6667C7.50008 16.6001 7.50008 17.0668 7.68174 17.4233C7.84153 17.7369 8.09649 17.9919 8.4101 18.1517C8.76662 18.3333 9.23333 18.3333 10.1667 18.3333Z" stroke="#8a6d3b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        <?php else: echo "N/A";
                        endif ?>
                    </div>

                </div>

                <div class="custom-card left-card my-4">
                    <div class="d-flex justify-content-between text-black" style="font-weight: bold;">
                        <p>Funding Wallet</p>
                        <p>Trade Wallet</p>
                    </div>

                    <div class="d-flex" style="gap: 1rem;">
                        <div class="card rounded" style="width: 18rem;background-color: #bfa573;">
                            <div class="card-body p-2">
                                <h5 class="card-title text-black mb-0 fw-bold">USDT </h5>
                                <h2 class="text-right text-black"><?= '$ ' . @number_format($balance["fund"]->usdt?? 0, 2, '.', ',') ?></h2>
                            </div>
                        </div>
                        <div class="card rounded" style="width: 18rem;background-color: #bfa573;">
                            <div class="card-body p-2">
                                <h5 class="card-title text-black mb-0 fw-bold">BTC</h5>
                                <h2 class="text-right text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" class="bi bi-currency-bitcoin" viewBox="0 0 30 30" id="Currency-Bitcoin--Streamline-Bootstrap" height="30" width="30">
                                        <path d="M10.3125 24.375v2.34375c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875h1.875a0.46875 0.46875 0 0 0 0.46875 -0.46875V24.375h0.9375v2.34375c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875h1.875a0.46875 0.46875 0 0 0 0.46875 -0.46875V24.375h0.1575c3.735 0 6.405 -1.936875 6.405 -5.2875 0 -2.81625 -1.8881249999999998 -4.355625 -4.09875 -4.575v-0.16499999999999998c1.8187499999999999 -0.45375 3.155625 -1.82625 3.155625 -4.10625C22.494374999999998 7.36875 20.338124999999998 5.625 17.0475 5.625H16.875V3.28125a0.46875 0.46875 0 0 0 -0.46875 -0.46875h-1.875a0.46875 0.46875 0 0 0 -0.46875 0.46875V5.625h-1.0743749999999999V3.28125a0.46875 0.46875 0 0 0 -0.46875 -0.46875H10.78125a0.46875 0.46875 0 0 0 -0.46875 0.46875V5.625l-3.74625 0.020624999999999998a0.46875 0.46875 0 0 0 -0.46875 0.46875v1.8543749999999999c0 0.256875 0.20625 0.46875 0.46499999999999997 0.46875l1.415625 -0.009375a1.40625 1.40625 0 0 1 1.396875 1.40625v10.321875a1.40625 1.40625 0 0 1 -1.40625 1.40625l-1.4025 0.020624999999999998a0.46875 0.46875 0 0 0 -0.46875 0.46875v1.875c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875zm2.675625 -15.961875h3.223125c1.69875 0 2.69625 0.93375 2.69625 2.46 0 1.633125 -1.078125 2.55375 -3.519375 2.55375h-2.4zm0 7.595625h3.45c2.131875 0 3.2925 1.0875 3.2925 2.8575 0 1.786875 -1.17375 2.71875 -4.04625 2.71875H12.988125z" stroke-width="1.875"></path>
                                    </svg>
                                    <?= @number_format($balance["fund"]->btc ?? 0, 6, '.', ',') ?>
                                </h2>
                            </div>
                        </div>
                        <div class="card rounded" style="width: 18rem;background-color: #bfa573;">
                            <div class="card-body p-2">
                                <h5 class="card-title text-black mb-0 fw-bold">USDT </h5>
                                <h2 class="text-right text-black"><?= '$ ' . @number_format($balance["trade"]->usdt ?? 0, 2, '.', ',') ?></h2>
                            </div>
                        </div>
                        <div class="card rounded" style="width: 18rem;background-color: #bfa573;">
                            <div class="card-body p-2">
                                <h5 class="card-title text-black mb-0 fw-bold">BTC</h5>
                                <h2 class="text-right text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" class="bi bi-currency-bitcoin" viewBox="0 0 30 30" id="Currency-Bitcoin--Streamline-Bootstrap" height="30" width="30">
                                        <path d="M10.3125 24.375v2.34375c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875h1.875a0.46875 0.46875 0 0 0 0.46875 -0.46875V24.375h0.9375v2.34375c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875h1.875a0.46875 0.46875 0 0 0 0.46875 -0.46875V24.375h0.1575c3.735 0 6.405 -1.936875 6.405 -5.2875 0 -2.81625 -1.8881249999999998 -4.355625 -4.09875 -4.575v-0.16499999999999998c1.8187499999999999 -0.45375 3.155625 -1.82625 3.155625 -4.10625C22.494374999999998 7.36875 20.338124999999998 5.625 17.0475 5.625H16.875V3.28125a0.46875 0.46875 0 0 0 -0.46875 -0.46875h-1.875a0.46875 0.46875 0 0 0 -0.46875 0.46875V5.625h-1.0743749999999999V3.28125a0.46875 0.46875 0 0 0 -0.46875 -0.46875H10.78125a0.46875 0.46875 0 0 0 -0.46875 0.46875V5.625l-3.74625 0.020624999999999998a0.46875 0.46875 0 0 0 -0.46875 0.46875v1.8543749999999999c0 0.256875 0.20625 0.46875 0.46499999999999997 0.46875l1.415625 -0.009375a1.40625 1.40625 0 0 1 1.396875 1.40625v10.321875a1.40625 1.40625 0 0 1 -1.40625 1.40625l-1.4025 0.020624999999999998a0.46875 0.46875 0 0 0 -0.46875 0.46875v1.875c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875zm2.675625 -15.961875h3.223125c1.69875 0 2.69625 0.93375 2.69625 2.46 0 1.633125 -1.078125 2.55375 -3.519375 2.55375h-2.4zm0 7.595625h3.45c2.131875 0 3.2925 1.0875 3.2925 2.8575 0 1.786875 -1.17375 2.71875 -4.04625 2.71875H12.988125z" stroke-width="1.875"></path>
                                    </svg>
                                    <?= @number_format($balance["trade"]->btc ?? 0, 6, '.', ',') ?>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row content-body">
                    <div class="col-lg-12 dash-table-referralmember">
                        <h4 class="text-white my-3 text-uppercase fw-bold">DEPOSIT</h4>
                        <table id="table_depositmember" class="table table-striped" style="width:100%">
                            <thead class="thead_referralmember">
                                <tr>
                                    <th>DATE</th>
                                    <th>AMOUNT DEPOSIT</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row content-body">
                    <div class="col-lg-12 dash-table-referralmember">
                        <h4 class="text-white my-3 text-uppercase fw-bold">Transaction</h4>
                        <table id="table_transaction" class="table table-striped" style="width:100%">
                            <thead class="thead_referralmember">
                                <tr>
                                    <th>Buy Price</th>
                                    <th>Sell Price</th>
                                    <th>Amount BTC</th>
                                    <th>Profit Gross</th>
                                    <th>Profit NET</th>
                                    <th>Master</th>
                                    <th>Referral</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- Referral Tables -->
                <div class="row content-body">
                    <div class="col-lg-12 dash-table-referralmember">
                        <h4 class="text-white my-3 text-uppercase fw-bold">Commission</h4>
                        <table id="table_commission" class="table table-striped" style="width:100%">
                            <thead class="thead_referralmember">
                                <tr>
                                    <th>Description</th>
                                    <th>COMISSION</th>
                                    <!-- <th>SUBSCRIPTION</th> -->
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- Referral Tables -->
                <div class="row content-body">
                    <div class="col-lg-12 dash-table-referralmember">
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

<input type="hidden" id="id" value="<?= $member->id ?>">