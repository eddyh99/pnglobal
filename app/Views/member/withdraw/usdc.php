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
                <a href="<?= BASE_URL ?>member/withdraw" class="back-button" style="display: flex; align-items: center; justify-content: center; text-decoration: none; color: #FFFFFF; font-weight: bold;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="14" viewBox="0 0 11 14" fill="none" style="margin-right: 10px;">
                        <path d="M0 7L10.5 0.937822V13.0622L0 7Z" fill="#B48B3D" />
                    </svg>
                    BACK
                </a>
                <div class="withdraw-comission">

                    <div class="row referral-cards mb-4">
                        <div class="col-md-6">
                            <div class="custom-card left-card">
                                <div class="card-row card-top">
                                    Available Commission to Withdraw
                                </div>
                                <div class="card-row card-bottom">
                                    Loading...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <form action="<?= BASE_URL ?>member/withdraw/request_withdraw" method="POST">
                    <div class="send-signals">
                        <div class="title-signal-preview d-flex justify-content-between align-items-center">
                            <h4>Withdraw Form</h4>
                        </div>
                        <div class="main-send-signal d-flex flex-column align-items-center justify-content-center">
                            <form action="" method="POST">
                                <div class="row w-100">
                                    <div class="form-addreferral col-8 mx-auto">
                                        <input type="hidden" name="type" value="usdt">
                                        <!-- <div class="wrapper-addreferral">
                                            <label for="amount">Amount To Withdraw</label>
                                            <input type="number" name="amount" class="form-control">
                                        </div> -->
                                        <div class="wrapper-addreferral">
                                            <label for="wallet_address">Wallet Address</label>
                                            <input type="text" name="wallet_address" class="form-control">
                                        </div>
                                        <div class="wrapper-addreferral">
                                            <label for="network">Network</label>
                                            <input type="text" name="network" class="form-control text-center" value="BLOCKCHAIN" readonly>
                                        </div>
                                        <div class="wrapper-addreferral d-flex justify-content-center">
                                            <button type="submit" id="submitBtn" class="btn btn-primary text-black">Confirm</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalAvailableCommission" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Pesan akan dimuat secara dinamis -->
            </div>
        </div>
    </div>
</div>