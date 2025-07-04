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
                <?php if ($isreferral): ?>

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
                <?php endif ?>
                <form action="<?= BASE_URL ?>hedgefund/withdraw/transfer_confirm/fund" method="post">
                    <input type="hidden" name="from" value="fund">
                    <input type="hidden" name="to" value="trade">
                    <!-- Wallet Info -->
                    <div class="row text-start mb-5 wallet-info-container">
                        <!-- Funding Wallet -->
                        <div class="col-md-4">
                            <div class="text-gold mb-2 fw-bold">Funding Wallet</div>
                            <div class="d-flex justify-content-between gap-3 balance-group">
                                <div class="px-4 py-2 balance-box text-gold">
                                    <?= number_format($balance['fund']->usdt ?? 0, 2) ?> <strong>USDT</strong>
                                </div>
                                <div class="px-4 py-2 balance-box text-gold">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#b48b3d" class="bi bi-currency-bitcoin" viewBox="0 0 16 16" id="Currency-Bitcoin--Streamline-Bootstrap" height="16" width="16">
                                        <path d="M5.5 13v1.25c0 0.138 0.112 0.25 0.25 0.25h1a0.25 0.25 0 0 0 0.25 -0.25V13h0.5v1.25c0 0.138 0.112 0.25 0.25 0.25h1a0.25 0.25 0 0 0 0.25 -0.25V13h0.084c1.992 0 3.416 -1.033 3.416 -2.82 0 -1.502 -1.007 -2.323 -2.186 -2.44v-0.088c0.97 -0.242 1.683 -0.974 1.683 -2.19C11.997 3.93 10.847 3 9.092 3H9V1.75a0.25 0.25 0 0 0 -0.25 -0.25h-1a0.25 0.25 0 0 0 -0.25 0.25V3h-0.573V1.75a0.25 0.25 0 0 0 -0.25 -0.25H5.75a0.25 0.25 0 0 0 -0.25 0.25V3l-1.998 0.011a0.25 0.25 0 0 0 -0.25 0.25v0.989c0 0.137 0.11 0.25 0.248 0.25l0.755 -0.005a0.75 0.75 0 0 1 0.745 0.75v5.505a0.75 0.75 0 0 1 -0.75 0.75l-0.748 0.011a0.25 0.25 0 0 0 -0.25 0.25v1c0 0.138 0.112 0.25 0.25 0.25zm1.427 -8.513h1.719c0.906 0 1.438 0.498 1.438 1.312 0 0.871 -0.575 1.362 -1.877 1.362h-1.28zm0 4.051h1.84c1.137 0 1.756 0.58 1.756 1.524 0 0.953 -0.626 1.45 -2.158 1.45H6.927z" stroke-width="1"></path>
                                    </svg>
                                    <?= number_format($balance['fund']->btc ?? 0, 6) ?> <strong>BTC</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Unified Trading Wallet -->
                        <div class="col-md-4">
                            <div class="text-gold mb-2 fw-bold">Unified Trading Wallet</div>
                            <div class="d-flex justify-content-between gap-3 balance-group">
                                <div class="px-4 py-2 balance-box text-gold">
                                    <?= number_format($balance['trade']->usdt ?? 0, 2) ?> <strong>USDT</strong>
                                </div>
                                <div class="px-4 py-2 balance-box text-gold">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#b48b3d" class="bi bi-currency-bitcoin" viewBox="0 0 16 16" id="Currency-Bitcoin--Streamline-Bootstrap" height="16" width="16">
                                        <path d="M5.5 13v1.25c0 0.138 0.112 0.25 0.25 0.25h1a0.25 0.25 0 0 0 0.25 -0.25V13h0.5v1.25c0 0.138 0.112 0.25 0.25 0.25h1a0.25 0.25 0 0 0 0.25 -0.25V13h0.084c1.992 0 3.416 -1.033 3.416 -2.82 0 -1.502 -1.007 -2.323 -2.186 -2.44v-0.088c0.97 -0.242 1.683 -0.974 1.683 -2.19C11.997 3.93 10.847 3 9.092 3H9V1.75a0.25 0.25 0 0 0 -0.25 -0.25h-1a0.25 0.25 0 0 0 -0.25 0.25V3h-0.573V1.75a0.25 0.25 0 0 0 -0.25 -0.25H5.75a0.25 0.25 0 0 0 -0.25 0.25V3l-1.998 0.011a0.25 0.25 0 0 0 -0.25 0.25v0.989c0 0.137 0.11 0.25 0.248 0.25l0.755 -0.005a0.75 0.75 0 0 1 0.745 0.75v5.505a0.75 0.75 0 0 1 -0.75 0.75l-0.748 0.011a0.25 0.25 0 0 0 -0.25 0.25v1c0 0.138 0.112 0.25 0.25 0.25zm1.427 -8.513h1.719c0.906 0 1.438 0.498 1.438 1.312 0 0.871 -0.575 1.362 -1.877 1.362h-1.28zm0 4.051h1.84c1.137 0 1.756 0.58 1.756 1.524 0 0.953 -0.626 1.45 -2.158 1.45H6.927z" stroke-width="1"></path>
                                    </svg>
                                    <?= number_format($balance['trade']->btc ?? 0, 6) ?> <strong>BTC</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Commission -->
                        <div class="col-md-4">
                            <div class="text-gold mb-2 fw-bold">Commission</div>
                            <div class="d-flex justify-content-between gap-3 balance-group">
                                <div class="px-4 py-2 balance-box text-gold w-100">
                                    <?= number_format($balance['commission']->usdt ?? 0, 2) ?> <strong>USDT</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mx-auto text-start mt-5">

                        <label class="form-label fw-bold text-gold w-100">Coin</label>
                        <div class="wrapper-input">
                            <input type="hidden" name="coin-type" value="usdt">
                            <div class="input-container">
                                <select id="coin" name="coin-type" class="form-control text-center fw-bold">
                                    <option value="usdt" selected>USDT</option>
                                </select>
                            </div>
                        </div>

                        <label class="form-label fw-bold text-gold w-100">Amount</label>
                        <div class="wrapper-input">
                            <div class="input-container">
                                <input type="number" id="amount" name="amount" class="form-control text-center fw-bold no-spinner" step="0.000001" placeholder="10,000">
                                <div id="pairusdt" class="px-3 fw-bold text-gold">USDT</div>
                                <div id="maxbalance" class="px-3 fw-bold text-gold" style="cursor: pointer;">MAX</div>
                            </div>
                        </div>

                        <div id="availablebalance" class="d-flex justify-content-between text-white px-1 mb-4 small">
                            <div>Available Balance</div>
                            <div id="textbalance" class="text-gold"><?= number_format($balance['fund']->usdt ?? 0) ?> USDT</div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn py-2 fw-bold"
                                style="width: 200px; background: linear-gradient(92deg, #b48b3d 0%, #bfa573 100%); color: black !important; border-radius: 6px;">
                                Confirm
                            </button>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>