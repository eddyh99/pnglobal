<!-- Page Content  -->
<section class="elite-page">
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="site-title"><span>HEDGE</span> FUND</h1>
            <p class="site-subtitle">Direct and Personalized Bitcoin Wallet Management.</p>
        </div>

        <!-- Sign-in box with centered buttons -->
        <div class="sign-in-box text-center p-4">
            <h1 class="fw-bold mb-4">SELECT NETWORK OPTION</h1>
            <?php
            $currentUrl = current_url();
            ?>
            <!-- Flexbox container for centering buttons -->
            <div class="d-flex flex-column justify-content-center align-items-center" style="height: 350px;">
                <?php if (str_contains($currentUrl, 'usdt_payment')): ?>
                    <a href="<?= BASE_URL ?>hedgefund/auth/deposit_payment/usdt/bep20" class="btn btn-primary btn-lg w-75">BEP 20</a>
                    <a href="<?= BASE_URL ?>hedgefund/auth/deposit_payment/usdt/trc20" class="btn btn-primary btn-lg w-75 mt-3">TRC 20</a>
                    <a href="<?= BASE_URL ?>hedgefund/auth/deposit_payment/usdt/erc20" class="btn btn-primary btn-lg w-75 mt-3">ERC 20</a>
                    <a href="<?= BASE_URL ?>hedgefund/auth/deposit_payment/usdt/polygon" class="btn btn-primary btn-lg w-75 mt-3">Polygon</a>
                <?php elseif (str_contains($currentUrl, 'usdc_payment')): ?>
                    <a href="<?= BASE_URL ?>hedgefund/auth/deposit_payment/usdc/bep20" class="btn btn-primary btn-lg w-75">BEP 20</a>
                    <a href="<?= BASE_URL ?>hedgefund/auth/deposit_payment/usdc/trc20" class="btn btn-primary btn-lg w-75 mt-3">TRC 20</a>
                    <a href="<?= BASE_URL ?>hedgefund/auth/deposit_payment/usdc/erc20" class="btn btn-primary btn-lg w-75 mt-3">ERC 20</a>
                    <a href="<?= BASE_URL ?>hedgefund/auth/deposit_payment/usdc/polygon" class="btn btn-primary btn-lg w-75 mt-3">Polygon</a>
                    <a href="<?= BASE_URL ?>hedgefund/auth/deposit_payment/usdc/base" class="btn btn-primary btn-lg w-75 mt-3">Base</a>
                    <a href="<?= BASE_URL ?>hedgefund/auth/deposit_payment/usdc/solana" class="btn btn-primary btn-lg w-75 mt-3">Solana</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Modal untuk menampilkan pesan sukses -->
<div class="modal fade" id="paymentSuccessModal" tabindex="-1" role="dialog" aria-labelledby="paymentSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered custom-modal-size" role="document">
        <div class="modal-content custom-modal-bg">
            <div class="modal-header">
                <h4 class="modal-title" id="paymentSuccessModalLabel">Payment Successful</h4>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="mb-4">
                        <i class="ri-checkbox-circle-line text-success" style="font-size: 4rem;"></i>
                    </div>
                    <p>Your payment is being processed and your account will be ready within 48 hours.</p>
                    <p>We will send you an email when your account is active.</p>
                </div>
            </div>
        </div>
    </div>
</div>