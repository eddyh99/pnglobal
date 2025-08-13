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
<div class="content-page">
    <div class="container-fluid">
        <div class="row content-body">
            <!-- Card Summary -->
            <div class="col-lg-12">
                <div class="container-fluid">
                    <div class="row dash-statistics">
                        <div class="col-12 col-sm-6 col-lg-3 mb-2">
                            <a class="d-block h-75">
                                <div class="iq-card h-100">
                                    <div class="iq-card-body">
                                        <div class="d-flex flex-column justify-content-center align-items-start">
                                            <div>
                                                <h5 class="text-black">Total Op Fondo</h5>
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
                                                <h5 class="text-black">Total Net Stor CLi</h5>
                                            </div>
                                            <div class="mt-3 text-center mx-auto">
                                                <h2 id="totalNetStorCli" class="text-black fw-bold text-center">Loading...</h2>
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
                                                <h5 class="text-black">Messe</h5>
                                            </div>
                                            <div class="mt-3 text-center mx-auto">
                                                <h2 id="messe" class="text-black fw-bold text-center">Loading...</h2>
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
                                                <h5 class="text-black">Media % Messe</h5>
                                            </div>
                                            <div class="mt-3 text-center mx-auto">
                                                <h2 id="media%mese" class="text-black fw-bold text-center">Loading...</h2>
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
            <div class="col-lg-12 dash-table-totalmember">
                <h4 class="text-white my-3 text-uppercase fw-bold">Principe</h4>
                <div class="row">
                    <div class="col-md-3">
                        <label for="bulan_filter" class="form-label text-white">Select Month:</label>
                        <input type="month" id="bulan_filter" class="form-control mb-3" value="<?= date('Y-m') ?>">
                    </div>
                </div>
                <table id="principe-table" class="table table-striped" style="width:100%">
                    <thead class="thead_referralmember">
                        <tr>
                            <th>Prezzo Buy</th>
                            <th>Prezzo Sell</th>
                            <th>Comm Buy</th>
                            <th>Comm Sell</th>
                            <th>Net</th>
                            <th>Op Fondo</th>
                            <th>Net Stor Cli</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>