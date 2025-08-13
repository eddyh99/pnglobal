<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid">
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
            <div class="col-lg-12">
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
                                            <h5 class="text-black">Trading Wallet</h5>
                                            <div class="mt-3 w-100 d-flex justify-content-end">
                                                <h2 id="trade_balance" class="text-right text-black">Loading...</h2>
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
                                            <h5 class="text-black">Binance Wallet</h5>
                                            <div class="mt-3 w-100 d-flex justify-content-end">
                                                <h2 id="binance" class="text-right text-black">Loading...</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>                        
                        </div>
                    </div>
                    <div class="row dash-statistics">
                        <div class="col-12 col-sm-6 col-lg-3 mb-2">
                            <a  class="d-block h-75">
                                <div class="iq-card h-100">
                                    <div class="iq-card-body">
                                        <div class="d-flex flex-column justify-content-center align-items-start">
                                            <div>
                                                <h5 class="text-black">Member Deposit</h5>
                                            </div>
                                            <div class="mt-3 text-center mx-auto">
                                                <h2 id="mdepo" class="text-black fw-bold text-center">Loading...</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3 mb-2">
                            <a  class="d-block h-75">
                                <div class="iq-card h-100">
                                    <div class="iq-card-body">
                                        <div class="d-flex flex-column justify-content-center align-items-start">
                                            <div>
                                                <h5 class="text-black">Comission Deposit</h5>
                                            </div>
                                            <div class="mt-3 text-center mx-auto">
                                                <h2 id="mcom" class="text-black fw-bold text-center">Loading...</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3 mb-2">
                            <a  class="d-block h-75">
                                <div class="iq-card h-100">
                                    <div class="iq-card-body">
                                        <div class="d-flex flex-column justify-content-center align-items-start">
                                            <div>
                                                <h5 class="text-black">Member Withdraw</h5>
                                            </div>
                                            <div class="mt-3 text-center mx-auto">
                                                <h2 id="mwithdraw" class="text-black fw-bold text-center">Loading...</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <table id="table_message" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Order Price</th>
                            <th>Closed Price</th>
                            <th>Profit</th>
                            <th>Client Profit</th>
                            <th>PN Global</th>
                            <th>Referral</th>
                            <th>Closed Time</th>
                            <!-- <th>ACTION</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <th>Total</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    <?php if (!empty(session('failed'))) { ?>
        setTimeout(function() {
            Swal.fire({
                text: `<?= session('failed') ?>`,
                showCloseButton: true,
                showConfirmButton: false,
                background: '#FFE4DC',
                color: '#000000',
                position: 'top-end',
                timer: 3000,
                timerProgressBar: true,
            });
        }, 100);
    <?php } else if (!empty(session('success'))) { ?>
        setTimeout(function() {
            Swal.fire({
                text: `<?= session('success') ?>`,
                showCloseButton: true,
                showConfirmButton: false,
                background: '#E1FFF7',
                color: '#000000',
                position: 'top-end',
                timer: 3000,
                timerProgressBar: true,
            });
        }, 100);
    <?php } ?>

    <?php if (!empty(session('error_validation'))) { ?>
        setTimeout(function() {
            Swal.fire({
                html: '<?= trim(str_replace('"', '', json_encode($_SESSION['error_validation']))) ?>',
                showCloseButton: true,
                showConfirmButton: false,
                background: '#FFE4DC',
                color: '#000000',
                position: 'top-end',
                timer: 3000,
                timerProgressBar: true,
            });
        }, 100);
    <?php } ?>
</script>