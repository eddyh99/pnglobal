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
            <div class="col-lg-12 dash-table-referralmember mt-5">
                <h4 class="text-white my-3 text-uppercase fw-bold">Calculator Mediation</h4>
                <table id="history-table" class="table table-striped" style="width:100%">
                    <thead class="thead_referralmember">
                        <tr>
                            <th>Prezzo Buy</th>
                            <th>Prezzo Sell</th>
                            <th>Comm Buy</th>
                            <th>Comm Sell</th>
                            <th>Tot Comm</th>
                            <th>Net</th>
                            <th>%</th>
                            <th>% Su Cap</th>
                        </tr>
                    </thead>
                    <tbody id="calcTable">
                        <tr>
                            <td><input type="number" class="buy-input"></td>
                            <td><input type="number" class="sell-input"></td>
                            <td class="comm-buy"></td>
                            <td class="comm-sell"></td>
                            <td class="tot-comm"></td>
                            <td class="net"></td>
                            <td class="percent" style="color: green;"></td>
                            <td class="percent-su-cap"></td>
                        </tr>
                        <tr>
                            <td><input type="number" class="buy-input"></td>
                            <td><input type="number" class="sell-input"></td>
                            <td class="comm-buy"></td>
                            <td class="comm-sell"></td>
                            <td class="tot-comm"></td>
                            <td class="net"></td>
                            <td class="percent" style="color: green;"></td>
                            <td class="percent-su-cap"></td>
                        </tr>
                        <tr>
                            <td><input type="number" class="buy-input"></td>
                            <td><input type="number" class="sell-input"></td>
                            <td class="comm-buy"></td>
                            <td class="comm-sell"></td>
                            <td class="tot-comm"></td>
                            <td class="net"></td>
                            <td class="percent" style="color: green;"></td>
                            <td class="percent-su-cap"></td>
                        </tr>
                        <tr>
                            <td><input type="number" class="buy-input"></td>
                            <td><input type="number" class="sell-input"></td>
                            <td class="comm-buy"></td>
                            <td class="comm-sell"></td>
                            <td class="tot-comm"></td>
                            <td class="net"></td>
                            <td class="percent" style="color: green;"></td>
                            <td class="percent-su-cap"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
