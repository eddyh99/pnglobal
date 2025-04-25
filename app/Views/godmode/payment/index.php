<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid payment-page">

        <div class="tab-navigation">
            <a href="javascript:void(0);" class="tab-item" data-tab="pn-global">LUX BTC</a>
            <a href="javascript:void(0);" class="tab-item" data-tab="elite-btc">HEDGE FUND</a>
            <a href="javascript:void(0);" class="tab-item" data-tab="satoshi-signal">SATOSHI SIGNAL</a>
        </div>

        <div id="pn-global" class="tab-content" style="display: none;">

            <div class="row content-body">
                <div class="col-lg-12 dash-table-referralmember mt-5">
                    <h4 class="text-white my-3 text-uppercase fw-bold">Request Payment</h4>
                    <table id="table_referralmember" class="table table-striped" style="width:100%">
                        <thead class="thead_referralmember">
                            <tr>
                                <th>EMAIL</th>
                                <th>REQUEST DATE</th>
                                <th>AMOUNT</th>
                                <th>METHOD</th>
                                <th>DETAIL</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- elite btc -->
        <div id="elite-btc" class="tab-content" style="display: none;">

        <div class="row content-body">
            <div class="col-lg-12 dash-table-referralmember mt-5">
                <h4 class="text-white my-3 text-uppercase fw-bold">Request Payment</h4>
                <table id="table_elitebtc_requestpayment" class="table table-striped" style="width:100%">
                    <thead class="thead_referralmember">
                        <tr>
                            <th>EMAIL</th>
                            <th>REQUEST DATE</th>
                            <th>AMOUNT</th>
                            <th>METHOD</th>
                            <th>DETAIL</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
         <!-- end -->

        <div id="satoshi-signal" class="tab-content" style="display: none;">
            <div class="row content-body">
                <div class="col-lg-12 dash-table-referralmember mt-5">
                    <h4 class="text-white my-3 text-uppercase fw-bold">Request Payment</h4>
                    <table id="table_satoshi_requestpayment" class="table table-striped" style="width:100%">
                        <thead class="thead_referralmember">
                            <tr>
                                <th>EMAIL</th>
                                <th>REQUEST DATE</th>
                                <th>AMOUNT</th>
                                <th>METHOD</th>
                                <th>DETAIL</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
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