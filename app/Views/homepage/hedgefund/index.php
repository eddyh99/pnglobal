    <link rel="stylesheet" href="<?= BASE_URL ?>assets/style/css/admin/mandatory/typography.css">

    <!-- Page Content  -->
    <div class="page-wrapper">
        <div class="crypto-consulting">
            <div class="row content-body mt-5 mb-5">
                <!-- Card Summary -->
                <div class="col-lg-12">
                    <div class="container-fluid">
                        <div class="row dash-statistics">
                            <!-- <div class="col-12 col-sm-6 col-lg-3 mb-2">
                                <a class="d-block h-75">
                                    <div class="iq-card h-100">
                                        <div class="iq-card-body">
                                            <div class="d-flex flex-column justify-content-center align-items-start">
                                                <div>
                                                    <h5 class="text-black">Total Op Fondo %</h5>
                                                </div>
                                                <div class="mt-3 text-center mx-auto">
                                                    <h2 id="totalOpFondo" class="text-black fw-bold text-center">Loading...</h2>
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
                                                    <h5 class="text-black">Total Net Stor CLi %</h5>
                                                </div>
                                                <div class="mt-3 text-center mx-auto">
                                                    <h2 id="totalNetStorCli" class="text-black fw-bold text-center">Loading...</h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div> -->
                            <div class="col-12 col-sm-6 col-lg-3 mb-2">
                                <a class="d-block h-75">
                                    <div class="iq-card h-100">
                                        <div class="iq-card-body">
                                            <div class="d-flex flex-column justify-content-center align-items-start">
                                                <div>
                                                    <h5 class="text-black">Month</h5>
                                                </div>
                                                <div class="mt-3 text-center mx-auto">
                                                    <h2 id="month" class="text-black fw-bold text-center">Loading...</h2>
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
                                                    <h5 class="text-black">Average % Month</h5>
                                                </div>
                                                <div class="mt-3 text-center mx-auto">
                                                    <h2 id="average_month" class="text-black fw-bold text-center">Loading...</h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- End Card Summary -->
                <!-- Table start -->
                <div class="col-lg-8 dash-table-totalmember mx-auto" style="border: 2px solid #bfa573; border-radius: 20px 20px 0px 0px;">
                    <h4 class=" text-white my-3 text-uppercase fw-bold">Hedgefund Result</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="bulan_filter" class="form-label text-white">Select Month:</label>
                            <input type="month" id="bulan_filter" class="form-control mb-3" value="<?= date('Y-m') ?>">
                        </div>
                    </div>
                    <table id="principe-table" class="table table-striped" style="width:100%">
                        <thead class="thead_referralmember">
                            <tr class="text-center">
                                <th>Buy Price</th>
                                <th>Sell Price</th>
                                <!-- <th>Comm Buy</th>
                                <th>Comm Sell</th>
                                <th>Net</th>
                                <th>Op Fondo %</th> -->
                                <th>Net Historical Customer %</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- table end -->
            </div>
        </div>
    </div>