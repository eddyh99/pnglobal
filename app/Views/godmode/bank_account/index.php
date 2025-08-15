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
            <div id="bankAccountView" class="col-lg-12 mb-5">
                <div class="send-signals">
                    <div class="title-signal-preview d-flex justify-content-between align-items-center">
                        <h4>Bank Account Details</h4>
                    </div>
                    <div class="main-send-signal d-flex flex-column align-items-center justify-content-center">
                        <div class="row w-100">
                            <div class="form-addreferral col-8 mx-auto">
                                <div class="wrapper-addreferral" style="border: 1px solid #bfa573; padding: 1rem; border-radius: 0.5rem;">
                                    <table style="width: 100%; border-collapse: collapse;">
                                        <tr>
                                            <th style="text-align: left; padding: 4px; width: 20%;">Bank Name</th>
                                            <td style="padding: 4px;">: <span id="viewName">-</span></td>
                                        </tr>
                                        <tr>
                                            <th style="text-align: left; padding: 4px;">Account Type</th>
                                            <td style="padding: 4px;">: <span id="viewType">-</span></td>
                                        </tr>
                                        <tr>
                                            <th style="text-align: left; padding: 4px;">Routing Number</th>
                                            <td style="padding: 4px;">: <span id="viewRouting">-</span></td>
                                        </tr>
                                        <tr>
                                            <th style="text-align: left; padding: 4px;">Account Number</th>
                                            <td style="padding: 4px;">: <span id="viewNumber">-</span></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center my-3">
                                    <a href="<?= BASE_URL ?>godmode/bank_account/edit" class="btn btn-primary">Edit Bank Account</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="bankAccountForm" class="col-lg-12">
                <form action="<?= BASE_URL ?>/godmode/bank_account/addbankaccount" method="POST">
                    <div class="send-signals">
                        <div class="title-signal-preview d-flex justify-content-between align-items-center">
                            <h4>Add Bank Account</h4>
                        </div>
                        <div class="main-send-signal d-flex flex-column align-items-center justify-content-center">
                            <div class="row w-100">
                                <div class="form-addreferral col-8 mx-auto">
                                    <div class="wrapper-addreferral">
                                        <label for="bank_account_name">Bank Account Name</label>
                                        <input type="text" name="bank_account_name" placeholder="Enter Bank Account Name" class="form-control">
                                    </div>
                                    <div class="wrapper-addreferral">
                                        <label>Account Type</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="bank_account_type" id="accountChecking" value="checking">
                                            <label class="form-check-label" for="accountChecking">Checking</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="bank_account_type" id="accountSaving" value="saving">
                                            <label class="form-check-label" for="accountSaving">Saving</label>
                                        </div>
                                    </div>
                                    <div class="wrapper-addreferral">
                                        <label for="bank_routing_number">Routing Number</label>
                                        <input type="text" name="bank_routing_number" placeholder="Enter Routing Number" class="form-control">
                                    </div>
                                    <div class="wrapper-addreferral">
                                        <label for="bank_account_number">Account Number</label>
                                        <input type="text" name="bank_account_number" placeholder="Enter Account Number" class="form-control">
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
            <div>

            </div>

        </div>
    </div>
</div>