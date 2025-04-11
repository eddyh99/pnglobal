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

<?php if (!empty(session('failed'))) {
    $failed = session('failed');
?>
    <div class="alert alert-danger fade show position-absolute" style="top: 1rem; right: 1rem; width: 30%; z-index: 99999;" role="alert">
        <div class="iq-alert-icon">
            <i class="ri-information-line"></i>
        </div>
        <div class="iq-alert-text text-black">
            <?php
            if (is_object($failed)) {
                echo '<ul style="margin-bottom:0">';
                foreach (get_object_vars($failed) as $key => $msg) {
                    echo '<li>' . htmlspecialchars("{$key}: {$msg}") . '</li>';
                }
                echo '</ul>';
            } else {
                echo htmlspecialchars($failed);
            }
            ?>

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
                                <a href="https://pnglobalinternational.com/<?= $refcode ?>" target="_blank">
                                    https://pnglobalinternational.com/<?= $refcode ?>
                                </a>
                            </div>
                            <div class="referral-qr">
                                <!-- icons... -->
                                <p>Show QR Code</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="<?= BASE_URL ?>elite/withdraw/transfer_confirm">

                    <div class="mb-4">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3" style="background-color: #b48b3d; color: white;">FROM</span>
                            <select class="form-control" name="from" aria-label="Default select example" style="border-color: #b48b3d;">
                                <option value="fund">Funding Wallet</option>
                                <option value="trade">Unified Trading Wallet</option>
                                <option value="commission">Commission</option>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3" style="background-color: #b48b3d; color: white;">To</span>
                            <select class="form-control" name="to" aria-label="Default select example" style="border-color: #b48b3d;">
                                <option value="fund">Funding Wallet</option>
                                <option value="trade">Unified Trading Wallet</option>
                            </select>
                        </div>
                    </div>

                    <hr style="border-color: #b48b3d; opacity: 0.7;">

                    <!-- Wallet info -->
                    <div class="row text-center mb-4">
                        <div class="col-md-4">
                            <div class="wallet-label" style="color: #b48b3d; font-weight: bold;">Funding wallet</div>
                            <div class="wallet-box" style="border: 1px solid #b48b3d; border-radius: 8px; padding: 15px; margin-top: 5px;">
                                <?= $balance['fund']->usdt ?? 0 ?> <strong>USDT</strong><br> <?= $balance['fund']->btc ?? 0 ?> <strong>BTC</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="wallet-label" style="color: #b48b3d; font-weight: bold;">Unified Trading wallet</div>
                            <div class="wallet-box" style="border: 1px solid #b48b3d; border-radius: 8px; padding: 15px; margin-top: 5px;">
                                <?= $balance['trade']->usdt ?? 0 ?> <strong>USDT</strong><br><?= $balance['trade']->btc ?? 0 ?> <strong>BTC</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="wallet-label" style="color: #b48b3d; font-weight: bold;">Comission</div>
                            <div class="wallet-box" style="border: 1px solid #b48b3d; border-radius: 8px; padding: 15px; margin-top: 5px;">
                                <?= $balance['commission']->usdt ?? 0 ?> <strong>USD</strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mx-auto">
                        <div class="d-flex flex-column align-items-center" style="color: #b48b3d;">

                            <!-- Coin -->
                            <label for="coin" class="form-label fw-bold text-white">Coin</label>
                            <select id="coin" class="form-control mb-3 text-center" style="border-color: #b48b3d; background-color: #1c1c1c; color: #b48b3d;">
                                <option selected>USDT</option>
                                <option disabled>FIAT</option>
                            </select>

                            <!-- Amount -->
                            <label for="amount" class="form-label fw-bold text-white">Amount</label>
                            <input type="number" id="amount" name="amount" class="form-control text-center mb-3" style="border-color: #b48b3d; background-color: #1c1c1c; color: #b48b3d;" placeholder="Enter amount">

                            <!-- Button -->
                            <button type="submit" class="btn btn-lg mt-2 px-5" style="background-color: #b48b3d; color: #000; font-weight: bold;">
                                Confirm
                            </button>

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>