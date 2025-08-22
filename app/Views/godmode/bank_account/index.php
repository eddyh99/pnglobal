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
            <div id="USbankAccountForm" class="col-lg-12">
                <form action="<?= ($us_bank->code == 404) ? base_url('godmode/bank_account/addbankus') : base_url('godmode/bank_account/updatebankus') ?>" method="POST">
                    <div class="send-signals">
                        <div class="title-signal-preview d-flex justify-content-between align-items-center">
                            <h4>US Bank Account</h4>
                        </div>
                        <div class="main-send-signal d-flex flex-column align-items-center justify-content-center">
                            <div class="row w-100">
                                <div class="form-addreferral col-8 mx-auto">
                                    <div class="wrapper-addreferral">
                                        <label for="us_bank_account_name">Bank Account Name</label>
                                        <input type="text" id="us_bank_account_name" name="us_bank_account_name" placeholder="Enter Bank Account Name" class="form-control"
                                            value="<?= ($us_bank->code == 200) ? esc($us_bank->data->us_bank_account_name) : '' ?>">
                                    </div>

                                    <div class="wrapper-addreferral">
                                        <label>Account Type</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="us_bank_account_type" id="us_account_checking"
                                                value="checking" <?= ($us_bank->code == 200 && $us_bank->data->us_bank_account_type == 'checking') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="us_account_checking">Checking</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="us_bank_account_type" id="us_account_saving"
                                                value="saving" <?= ($us_bank->code == 200 && $us_bank->data->us_bank_account_type == 'saving') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="us_account_saving">Saving</label>
                                        </div>
                                    </div>

                                    <div class="wrapper-addreferral">
                                        <label for="us_bank_routing_number">Routing Number</label>
                                        <input type="text" id="us_bank_routing_number" name="us_bank_routing_number" placeholder="Enter Routing Number" class="form-control"
                                            value="<?= ($us_bank->code == 200) ? esc($us_bank->data->us_bank_routing_number) : '' ?>">
                                    </div>

                                    <div class="wrapper-addreferral">
                                        <label for="us_bank_account_number">Account Number</label>
                                        <input type="text" id="us_bank_account_number" name="us_bank_account_number" placeholder="Enter Account Number" class="form-control"
                                            value="<?= ($us_bank->code == 200) ? esc($us_bank->data->us_bank_account_number) : '' ?>">
                                    </div>

                                    <div class="wrapper-addreferral">
                                        <label for="us_bank_fee_setting">US Fee Setting</label>
                                        <input type="text" id="us_bank_fee_setting" name="us_bank_fee_setting" placeholder="Enter Fee Setting" class="form-control"
                                            value="<?= ($us_bank->code == 200) ? esc($us_bank->data->us_bank_fee_setting) : '' ?>">
                                    </div>

                                    <div class="wrapper-addreferral d-flex justify-content-center">
                                        <button type="submit" id="submitBtn" class="btn btn-primary"><?= ($us_bank->code == 404) ? "Create Bank Account" : "Update Bank Account" ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div id="InternationalbankAccountForm" class="col-lg-12 mt-4">
                <form action="<?= ($international_bank->code == 404) ? base_url('godmode/bank_account/addbankinter') : base_url('godmode/bank_account/updatebankinter') ?>" method="POST">
                    <div class="send-signals">
                        <div class="title-signal-preview d-flex justify-content-between align-items-center">
                            <h4>International Bank Account</h4>
                        </div>
                        <div class="main-send-signal d-flex flex-column align-items-center justify-content-center">
                            <div class="row w-100">
                                <div class="form-addreferral col-8 mx-auto">

                                    <div class="wrapper-addreferral">
                                        <label for="inter_bank_account_name">Bank Account Name</label>
                                        <input type="text" id="inter_bank_account_name"
                                            name="inter_bank_account_name"
                                            value="<?= ($international_bank->code == 200) ? esc($international_bank->data->inter_bank_account_name) : '' ?>"
                                            placeholder="Enter Bank Account Name" class="form-control">
                                    </div>

                                    <div class="wrapper-addreferral">
                                        <label for="inter_bank_account_number">Account Number</label>
                                        <input type="text" id="inter_bank_account_number"
                                            name="inter_bank_account_number"
                                            value="<?= ($international_bank->code == 200) ? esc($international_bank->data->inter_bank_account_number) : '' ?>"
                                            placeholder="Enter Account Number" class="form-control">
                                    </div>

                                    <div class="wrapper-addreferral">
                                        <label for="inter_swift_code">Swift Code</label>
                                        <input type="text" id="inter_swift_code"
                                            name="inter_swift_code"
                                            value="<?= ($international_bank->code == 200) ? esc($international_bank->data->inter_swift_code) : '' ?>"
                                            placeholder="Enter Swift Code" class="form-control">
                                    </div>

                                    <div class="wrapper-addreferral">
                                        <label for="inter_bank_routing_number">International Routing Number</label>
                                        <input type="text" id="inter_bank_routing_number"
                                            name="inter_bank_routing_number"
                                            value="<?= ($international_bank->code == 200) ? esc($international_bank->data->inter_bank_routing_number) : '' ?>"
                                            placeholder="Enter Routing Number" class="form-control">
                                    </div>

                                    <div class="wrapper-addreferral">
                                        <label for="inter_bank_company_address">International Company Address</label>
                                        <input type="text" id="inter_bank_company_address"
                                            name="inter_bank_company_address"
                                            value="<?= ($international_bank->code == 200) ? esc($international_bank->data->inter_bank_company_address) : '' ?>"
                                            placeholder="Enter Company Address" class="form-control">
                                    </div>

                                    <div class="wrapper-addreferral">
                                        <label for="inter_fee_setting">International Fee Setting</label>
                                        <input type="text" id="inter_fee_setting"
                                            name="inter_fee_setting"
                                            value="<?= ($international_bank->code == 200) ? esc($international_bank->data->inter_fee_setting) : '' ?>"
                                            placeholder="Enter Fee Setting" class="form-control">
                                    </div>

                                    <div class="wrapper-addreferral d-flex justify-content-center">
                                        <button type="submit" id="submitBtnInternationalBank" class="btn btn-primary">
                                            <?= ($international_bank->code == 404) ? "Create Bank Account" : "Update Bank Account" ?>
                                        </button>
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