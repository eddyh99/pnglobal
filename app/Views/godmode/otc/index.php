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
            <div class="col-lg-12">
                <div class="send-signals">
                    <form action="" method="post">
                        <div class="title-signal-preview d-flex justify-content-between align-items-center">
                            <h4>Calculator OTC</h4>
                        </div>
                        <div class="main-send-signal d-flex flex-column align-items-center justify-content-center">
                            <div class="row w-100">
                                <div class="form-addreferral col-8 mx-auto">
                                    <div class="wrapper-addreferral">
                                        <label for="amount_btc">Amount BTC</label>
                                        <div class="d-flex">
                                            <input type="number" id="amount_btc" name="amount_btc" class="form-control" placeholder="0.001" step="any">
                                            <label class="d-flex align-items-center gap-1 ml-2">
                                                <input type="checkbox" name="lock_amount_btc" value="1">
                                                <p class="mb-0">🔒</p>
                                            </label>

                                        </div>
                                    </div>
                                    <div class="wrapper-addreferral">
                                        <label for="buy_price">Buy Price</label>
                                        <div class="d-flex">
                                            <input type="number" id="buy_price" name="buy_price" class="form-control" placeholder="0" step="any">
                                            <label class="d-flex align-items-center gap-1 ml-2">
                                                <input type="checkbox" name="lock_buy_price" value="1">
                                                <p class="mb-0">🔒</p>
                                            </label>

                                        </div>
                                    </div>
                                    <div class="wrapper-addreferral">
                                        <label for="sell_price">Sell Price</label>
                                        <div class="d-flex">
                                            <input type="number" id="sell_price" name="sell_price" class="form-control" placeholder="0" step="any">
                                            <label class="d-flex align-items-center gap-1 ml-2">
                                                <input type="checkbox" name="lock_sell_price" value="1">
                                                <p class="mb-0">🔒</p>
                                            </label>

                                        </div>
                                    </div>
                                    <div class="wrapper-addreferral d-flex justify-content-center mt-4">
                                        <button type="submit" id="calculateBtn" class="btn btn-primary">Calculate</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Bagian hasil perhitungan, disembunyikan secara default -->
            <div id="result-container" class="form-addreferral col-8 mx-auto" style="display: none;">
                <div class="wrapper-addreferral">
                    <label for="resultAmountBuyUSDT">Amount Buy USDT</label>
                    <input type="number" id="resultAmountBuyUSDT" name="resultAmountBuyUSDT" class="form-control" value="0" step="any" readonly>
                </div>
                <div class="wrapper-addreferral">
                    <label for="resultAmountsellUSDT">Amount Sell USDT</label>
                    <input type="number" id="resultAmountsellUSDT" name="resultAmountsellUSDT" class="form-control" value="0" step="any" readonly>
                </div>
                <div class="wrapper-addreferral">
                    <label for="profit">Profit</label>
                    <input type="number" id="profit" name="profit" class="form-control" value="0" step="any" readonly>
                </div>
            </div>
        </div>
    </div>
</div>