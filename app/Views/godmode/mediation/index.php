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
                <form id="calcForm" method="POST" action="">
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
                            <!-- Row 1 -->
                            <tr>
                                <td>
                                    <div class="d-flex flex-column align-items-start">
                                        <input type="number" name="prezzo_buy1" class="buy-input" value="" required>
                                        <label class="mt-1">
                                            <input type="checkbox" name="lock_buy1" value="1"> 🔒
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column align-items-start">
                                        <input type="number" name="prezzo_sell1" class="sell-input" value="" required>
                                        <label class="mt-1">
                                            <input type="checkbox" name="lock_sell1" value="1"> 🔒
                                        </label>
                                    </div>
                                </td>
                                <td class="comm-buy"></td>
                                <td class="comm-sell"></td>
                                <td class="tot-comm"></td>
                                <td class="net"></td>
                                <td class="percent" style="color: green;"></td>
                                <td class="percent-su-cap"></td>
                            </tr>

                            <!-- Row 2 -->
                            <tr>
                                <td>
                                    <div class="d-flex flex-column align-items-start">
                                        <input type="number" name="prezzo_buy2" class="buy-input" value="" required>
                                        <label class="mt-1">
                                            <input type="checkbox" name="lock_buy2" value="1"> 🔒
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column align-items-start">
                                        <input type="number" name="prezzo_sell2" class="sell-input" required>
                                        <label class="mt-1">
                                            <input type="checkbox" name="lock_sell2" value="1"> 🔒
                                        </label>
                                    </div>
                                </td>
                                <td class="comm-buy"></td>
                                <td class="comm-sell"></td>
                                <td class="tot-comm"></td>
                                <td class="net"></td>
                                <td class="percent" style="color: green;"></td>
                                <td class="percent-su-cap"></td>
                            </tr>

                            <!-- Row 3 -->
                            <tr>
                                <td>
                                    <div class="d-flex flex-column align-items-start">
                                        <input type="number" name="prezzo_buy3" class="buy-input" required>
                                        <label class="mt-1">
                                            <input type="checkbox" name="lock_buy3" value="1"> 🔒
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column align-items-start">
                                        <input type="number" name="prezzo_sell3" class="sell-input" required>
                                        <label class="mt-1">
                                            <input type="checkbox" name="lock_sell3" value="1"> 🔒
                                        </label>
                                    </div>
                                </td>
                                <td class="comm-buy"></td>
                                <td class="comm-sell"></td>
                                <td class="tot-comm"></td>
                                <td class="net"></td>
                                <td class="percent" style="color: green;"></td>
                                <td class="percent-su-cap"></td>
                            </tr>

                            <!-- Row 4 -->
                            <tr>
                                <td>
                                    <div class="d-flex flex-column align-items-start">
                                        <input type="number" name="prezzo_buy4" class="buy-input" required>
                                        <label class="mt-1">
                                            <input type="checkbox" name="lock_buy4" value="1"> 🔒
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column align-items-start">
                                        <input type="number" name="prezzo_sell4" class="sell-input" required>
                                        <label class="mt-1">
                                            <input type="checkbox" name="lock_sell4" value="1"> 🔒
                                        </label>
                                    </div>
                                </td>
                                <td class="comm-buy"></td>
                                <td class="comm-sell"></td>
                                <td class="tot-comm"></td>
                                <td class="net"></td>
                                <td class="percent" style="color: green;"></td>
                                <td class="percent-su-cap"></td>
                            </tr>
                        </tbody>

                    </table>
                    <div class="d-flex justify-content-center mb-5">
                        <button class="btn btn-primary" id="calcBtn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>