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
            <div id="bankAccountForm" class="col-lg-12">
                <form action="<?= BASE_URL ?>/godmode/bank_account/addbankaccount" method="POST">
                    <div class="send-signals">
                        <div class="title-signal-preview d-flex justify-content-between align-items-center">
                            <h4>Bank Account</h4>
                        </div>
                        <div class="main-send-signal d-flex flex-column align-items-center justify-content-center">
                            <div class="row w-100">
                                <div class="form-addreferral col-8 mx-auto">
                                    <div class="wrapper-addreferral">
                                        <label for="bank_account_name">Bank Account Name</label>
                                        <input type="text" name="bank_account_name" value="<?=$bank->bank_account_name?>" placeholder="Enter Bank Account Name" class="form-control">
                                    </div>
                                    <div class="wrapper-addreferral">
                                        <label>Account Type</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="bank_account_type" id="accountChecking" value="checking" <?=($bank->bank_account_type=="checking") ? "checked":"" ?>>
                                            <label class="form-check-label" for="accountChecking">Checking</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="bank_account_type" id="accountSaving" value="saving" <?=($bank->bank_account_type=="saving") ? "checked":"" ?>>
                                            <label class="form-check-label" for="accountSaving">Saving</label>
                                        </div>
                                    </div>
                                    <div class="wrapper-addreferral">
                                        <label for="bank_routing_number">Routing Number</label>
                                        <input type="text" name="bank_routing_number" value="<?=$bank->bank_routing_number?>" placeholder="Enter Routing Number" class="form-control">
                                    </div>
                                    <div class="wrapper-addreferral">
                                        <label for="bank_account_number">Account Number</label>
                                        <input type="text" name="bank_account_number" value="<?=$bank->bank_account_number?>" placeholder="Enter Account Number" class="form-control">
                                    </div>
                                    <div class="wrapper-addreferral d-flex justify-content-center">
                                        <button type="submit" id="submitBtn" class="btn btn-primary">Update Bank Account</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div>

            </div>

        </div>
    </div>
</div>