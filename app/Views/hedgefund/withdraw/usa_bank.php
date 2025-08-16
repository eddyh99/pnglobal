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
                <a href="<?= BASE_URL ?>hedgefund/withdraw/select_bank" class="back-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="14" viewBox="0 0 11 14" fill="none">
                        <path d="M0 7L10.5 0.937822V13.0622L0 7Z" fill="#B48B3D" />
                    </svg>
                    BACK
                </a>
                <div class="withdraw-comission">
                    <?=get_balance()?>
                </div>
            </div>

            <div id="bankAccountForm" class="col-lg-12">
                <form action="<?= BASE_URL ?>hedgefund/withdraw/request_withdraw" method="POST">
                    <input type="hidden" name="type" value="fiat">
                    <div class="send-signals">
                        <div class="title-signal-preview d-flex justify-content-between align-items-center">
                            <h4>Bank Account</h4>
                        </div>
                        <div class="main-send-signal d-flex flex-column align-items-center justify-content-center">
                            <div class="row w-100">
                                <div class="form-addreferral col-8 mx-auto">
                                    <div class="wrapper-addreferral">
                                        <label for="wallet_address">Amount</label>
                                        <div class="w-100 mb-1" style="min-width: 400px; margin: 0 auto;">
                                            <div class="d-flex align-items-center" style="border: 1px solid #b48b3d; background-color: #1c1c1c; height: 45px; border-radius: 5px;">
                                                <input type="number" id="amount" name="amount" step="0.01"
                                                    class="form-control text-center fw-bold no-spinner"
                                                    placeholder="10,000" max="<?=$balance['fund']->usdt?>" step="0.01"
                                                    style="background-color: transparent; color: #b48b3d; border: none; box-shadow: none;">
                                                <div class="px-3 fw-bold text-gold">USDT</div>
                                                <div id="maxbalance" class="px-3 fw-bold text-gold" style="cursor: pointer;">MAX</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper-addreferral">
                                        <label for="bank_account_name">Bank Account Name</label>
                                        <input type="text" name="recipient" placeholder="Enter Bank Account Name" class="form-control">
                                    </div>
                                    <div class="wrapper-addreferral">
                                        <label>Account Type</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="account_type" id="accountChecking" value="checking">
                                            <label class="form-check-label" for="accountChecking">Checking</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="account_type" id="accountSaving" value="saving">
                                            <label class="form-check-label" for="accountSaving">Saving</label>
                                        </div>
                                    </div>
                                    <div class="wrapper-addreferral">
                                        <label for="bank_routing_number">Routing Number</label>
                                        <input type="text" name="routing_number" placeholder="Enter Routing Number" class="form-control">
                                    </div>
                                    <div class="wrapper-addreferral">
                                        <label for="bank_account_number">Account Number</label>
                                        <input type="text" name="account_number" placeholder="Enter Account Number" class="form-control">
                                    </div>
                                    <div class="wrapper-addreferral d-flex justify-content-center">
                                        <button type="submit" id="submitBtn" class="btn btn-primary">Add Bank Account</button>
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