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
<div class="content-page mb-5 withdraw-usdt">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12 px-2">
                <a href="<?= BASE_URL ?>hedgefund/withdraw" class="back-button" style="display: flex; align-items: center; justify-content: center; text-decoration: none; color: #FFFFFF; font-weight: bold;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="14" viewBox="0 0 11 14" fill="none" style="margin-right: 10px;">
                        <path d="M0 7L10.5 0.937822V13.0622L0 7Z" fill="#B48B3D" />
                    </svg>
                    BACK
                </a>
                <div class="withdraw-comission">

                    <div class="row referral-cards mb-4">
                        <div class="col-lg-12 mb-2">
                            <div class="custom-card left-card mb-3">
                                <div class="card-row card-top text-center" style="font-weight: bold;">Funding Wallet</div>
                                <!-- <div class="card-row card-top">USDT</div>
                                <div class="card-row card-bottom">
                                    <?= '$ ' . @number_format($balance['fund']->usdt ?? 0, 0, '.', ',') ?>
                                </div> -->
    
                                <div class="d-flex" style="gap: 1rem;">
                                    <div class="card rounded" style="width: 18rem;background-color: #bfa573;">
                                        <div class="card-body p-2">
                                            <h5 class="card-title text-black mb-0 fw-bold">USDT </h5>
                                            <h2 class="text-right text-black"><?= '$ ' . @number_format($balance['fund']->usdt ?? 0, 0, '.', ',') ?></h2>
                                        </div>
                                    </div>
                                    <div class="card rounded" style="width: 18rem;background-color: #bfa573;">
                                        <div class="card-body p-2">
                                            <h5 class="card-title text-black mb-0 fw-bold">BTC</h5>
                                            <h2 class="text-right text-black">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" class="bi bi-currency-bitcoin" viewBox="0 0 30 30" id="Currency-Bitcoin--Streamline-Bootstrap" height="30" width="30">
                                                <path d="M10.3125 24.375v2.34375c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875h1.875a0.46875 0.46875 0 0 0 0.46875 -0.46875V24.375h0.9375v2.34375c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875h1.875a0.46875 0.46875 0 0 0 0.46875 -0.46875V24.375h0.1575c3.735 0 6.405 -1.936875 6.405 -5.2875 0 -2.81625 -1.8881249999999998 -4.355625 -4.09875 -4.575v-0.16499999999999998c1.8187499999999999 -0.45375 3.155625 -1.82625 3.155625 -4.10625C22.494374999999998 7.36875 20.338124999999998 5.625 17.0475 5.625H16.875V3.28125a0.46875 0.46875 0 0 0 -0.46875 -0.46875h-1.875a0.46875 0.46875 0 0 0 -0.46875 0.46875V5.625h-1.0743749999999999V3.28125a0.46875 0.46875 0 0 0 -0.46875 -0.46875H10.78125a0.46875 0.46875 0 0 0 -0.46875 0.46875V5.625l-3.74625 0.020624999999999998a0.46875 0.46875 0 0 0 -0.46875 0.46875v1.8543749999999999c0 0.256875 0.20625 0.46875 0.46499999999999997 0.46875l1.415625 -0.009375a1.40625 1.40625 0 0 1 1.396875 1.40625v10.321875a1.40625 1.40625 0 0 1 -1.40625 1.40625l-1.4025 0.020624999999999998a0.46875 0.46875 0 0 0 -0.46875 0.46875v1.875c0 0.25875000000000004 0.21 0.46875 0.46875 0.46875zm2.675625 -15.961875h3.223125c1.69875 0 2.69625 0.93375 2.69625 2.46 0 1.633125 -1.078125 2.55375 -3.519375 2.55375h-2.4zm0 7.595625h3.45c2.131875 0 3.2925 1.0875 3.2925 2.8575 0 1.786875 -1.17375 2.71875 -4.04625 2.71875H12.988125z" stroke-width="1.875"></path>
                                            </svg>
                                                <?= @number_format($balance['fund']->btc ?? 0, 6, '.', ',') ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <form action="<?= BASE_URL ?>hedgefund/withdraw/request_withdraw" method="POST">
                    <div class="send-signals">
                        <div class="title-signal-preview d-flex justify-content-between align-items-center">
                            <h4>WITHDRAW TO USDT</h4>
                        </div>
                        <div class="main-send-signal d-flex flex-column align-items-center justify-content-center">
                            <div class="row w-100">
                                <div class="form-addreferral col-8 mx-auto">
                                    <input type="hidden" name="type" value="usdt">
                                    <!-- <div class="wrapper-addreferral">
                                        <label for="amount">Amount To Withdraw</label>
                                        <input type="number" name="amount" class="form-control">
                                    </div> -->
                                    <div class="wrapper-addreferral">
                                        <label for="wallet_address">USDT Wallet Address</label>
                                        <input type="text" name="wallet_address" class="form-control">
                                    </div>
                                    <div class="wrapper-addreferral">
                                        <label for="wallet_address">Amount</label>
                                        <div class="w-100 mb-1" style="min-width: 400px; margin: 0 auto;">
                                            <div class="d-flex align-items-center" style="border: 1px solid #b48b3d; background-color: #1c1c1c; height: 45px; border-radius: 5px;">
                                                <input type="number" id="amount" name="amount"
                                                    class="form-control text-center fw-bold no-spinner"
                                                    placeholder="10,000"
                                                    style="background-color: transparent; color: #b48b3d; border: none; box-shadow: none;">
                                                <div class="px-3 fw-bold text-gold">USDT</div>
                                                <div id="maxbalance" class="px-3 fw-bold text-gold" style="cursor: pointer;">MAX</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper-addreferral">
                                        <label for="network">Network</label>
                                        <input type="text" name="network" class="form-control text-center" value="BEP20" readonly>
                                    </div>
                                    <div class="wrapper-addreferral d-flex justify-content-center">
                                        <button type="submit" id="submitBtn" class="btn btn-primary text-black">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalAvailableCommission">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
    </div>
  </div>
</div>

<!--<div class="modal fade" id="modalAvailableCommission" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">-->
<!--    <div class="modal-dialog"></div>-->
<!--    <div class="modal-content">-->
<!--        <div class="modal-header">-->
<!--            <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                <span aria-hidden="true">&times;</span>-->
<!--            </button>-->
<!--        </div>-->
<!--        <div class="modal-body">-->
<!--             Pesan akan dimuat secara dinamis -->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!--</div>-->