<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12">
                <div class="container-fluid">
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
                    <div class="row dash-statistics">
                        <div class="col-12 col-sm-6 col-lg-3 mb-2">
                            <a class="d-block h-75">
                                <div class="iq-card h-100">
                                    <div class="iq-card-body">
                                        <div class="d-flex flex-column justify-content-center align-items-start">
                                            <div>
                                                <h5 class="text-black">Total Profit</h5>
                                            </div>
                                            <div class="mt-3 text-center mx-auto">
                                                <h2 id="tprofit" class="text-black fw-bold text-center">Loading...</h2>
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
                                            <div>
                                                <h5 class="text-black">Client Profit</h5>
                                            </div>
                                            <div class="mt-3 text-center mx-auto">
                                                <h2 id="cprofit" class="text-black fw-bold text-center">Loading...</h2>
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
                                                <h5 class="text-black">Total Ref Commission</h5>
                                            </div>
                                            <div class="mt-3 text-center mx-auto">
                                                <h2 id="rprofit" class="text-black fw-bold text-center">Loading...</h2>
                                            </div>
                                        </div>
                                        <div class="disable"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3 mb-2">
                            <a class="d-block h-75">
                                <div class="iq-card h-100">
                                    <div class="iq-card-body">
                                        <div class="d-flex flex-column justify-content-center align-items-start">
                                            <div>
                                                <h5 class="text-black">PNGLOBAL Profit</h5>
                                            </div>
                                            <div class="mt-3 text-center mx-auto">
                                                <h2 id="mprofit" class="text-black fw-bold text-center">Loading...</h2>
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
                            <!--<th>Remaining</th>-->
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