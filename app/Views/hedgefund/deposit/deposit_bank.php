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
                        <h4>Deposit Information</h4>
                    </div>
                    <div class="main-send-signal d-flex flex-column align-items-center justify-content-center">
                        <div class="row w-100">
                            <div class="form-addreferral col-8 mx-auto">
                                <!-- Destination Bank -->
                                <div class="wrapper-addreferral" style="border: 1px solid #bfa573; padding: 1rem; border-radius: 0.5rem;">
                                    <h5 class="mb-3">Destination Bank</h5>
                                    <table style="width: 100%; border-collapse: collapse;" class="invoice-table">
                                        <tr>
                                            <th class="th-deposit">Bank Name</th>
                                            <td class="td-normal">: <span id="viewName">-</span></td>
                                        </tr>
                                        <tr>
                                            <th class="th-deposit">Account Type</th>
                                            <td class="td-normal">: <span id="viewType">-</span></td>
                                        </tr>
                                        <tr>
                                            <th class="th-deposit">Routing Number</th>
                                            <td class="td-input">
                                                : 
                                                <input id="viewRouting" type="text" value="<?= esc($routing ?? '-') ?>" readonly class="form-control-sm flex-grow-1">
                                                <button type="button" onclick="copyToClipboard('viewRouting')" class="button-copy">Copy</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="th-deposit">Account Number</th>
                                            <td class="td-input">
                                                : 
                                                <input id="viewAccountNumber" type="text" value="<?= esc($account_number ?? '-') ?>" readonly class="form-control-sm flex-grow-1">
                                                <button type="button" onclick="copyToClipboard('viewAccountNumber')" class="button-copy">Copy</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="th-deposit">Casual</th>
                                            <td class="td-input">
                                                : 
                                                <input id="viewCasual" type="text" value="<?= esc($order_id ?? '-') ?>" readonly class="form-control-sm flex-grow-1">
                                                <button type="button" onclick="copyToClipboard('viewCasual')" class="button-copy">Copy</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- End Destination Bank -->

                                <!-- Invoice Section -->
                                <div class="wrapper-addreferral mt-3" style="border: 1px solid #bfa573; padding: 1rem; border-radius: 0.5rem;">
                                    <h5 class="mb-3">Detail Amount Transfer</h5>
                                    <table style="width: 100%; border-collapse: collapse;">
                                        <tr>
                                            <th class="th-deposit">Payment Amount</th>
                                            <td class="td-normal">: <?= number_format($payamount ?? 0, 0) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="th-deposit">Fee Amount</th>
                                            <td class="td-normal">: <?= number_format($fee ?? 0, 0) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="th-deposit">Total Amount</th>
                                            <td class="td-input">
                                                :
                                                <input id="payTotal" type="text" value="$<?= number_format($total ?? 0, 0) ?>" readonly class="form-control-sm flex-grow-1 font-weight-bold">
                                                <button type="button" onclick="copyToClipboard('payTotal')" class="button-copy">Copy</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- End Invoice Section -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>