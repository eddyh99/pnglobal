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

<!-- Page Content -->
<div class="content-page mb-5">
    <div class="container-fluid">
        <div class="row content-body">
            <div id="CryptoPayment" class="col-lg-12 mb-5">
                <div class="send-signals">
                    <div class="title-signal-preview d-flex justify-content-between align-items-center">
                        <h4>Deposit Information</h4>
                    </div>
                    <div class="mt-3 text-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= urlencode($wallet->address) ?>"
                            alt="QR Code Wallet"
                            style="border: 1px solid #bfa573; padding: 10px; border-radius: 8px;">
                        <p class="mt-2">Scan this QR code to deposit</p>
                    </div>
                    <div class="main-send-signal d-flex flex-column align-items-center justify-content-center">
                        <div class="row w-100">
                            <div class="form-addreferral col-8 mx-auto">

                                <!-- Destination Wallet -->
                                <div class="wrapper-addreferral" style="border: 1px solid #bfa573; padding: 1rem; border-radius: 0.5rem;">
                                    <h5 class="mb-3">Destination Crypto Wallet</h5>
                                    <table style="width: 100%; border-collapse: collapse;" class="invoice-table">
                                        <tr>
                                            <th class="th-deposit">Invoice</th>
                                            <td class="td-normal">: <span id="viewInvoice"><?= esc($order_id) ?></span></td>
                                        </tr>
                                        <tr>
                                            <th class="th-deposit">Address</th>
                                            <td class="td-input">
                                                :
                                                <input id="addressWallet" type="text" value="<?= esc($wallet->address ?? '-') ?>" readonly
                                                    data-token="<?= esc($coint_network) ?>">
                                                <button type="button" onclick="copyWalletAddress()" class="button-copy">Copy</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="th-deposit">Network</th>
                                            <td class="td-normal">: <span><?= esc(strtoupper($wallet->network)) ?></span></td>
                                        </tr>
                                    </table>
                                    <p style="color: red;" class="mt-3">
                                        Please make sure to send funds <strong>only to the selected wallet address and network</strong>. Sending to any other address or network may result in permanent loss of your funds.
                                    </p>
                                </div>

                                <!-- Detail Amount -->
                                <div class="wrapper-addreferral mt-3" style="border: 1px solid #bfa573; padding: 1rem; border-radius: 0.5rem;">
                                    <h5 class="mb-3">Detail Amount <?= strtoupper($method_payment) ?></h5>
                                    <table style="width: 100%; border-collapse: collapse;">
                                        <tr>
                                            <th class="th-deposit">Payment Amount</th>
                                            <td class="td-normal">: $ <?= number_format($total_capital ?? 0, 0) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="th-deposit">Fee</th>
                                            <td class="td-normal">: $ <?= number_format($fee ?? 0, 0) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="th-deposit">Total Amount</th>
                                            <td class="td-input">
                                                :
                                                <input id="payTotal" type="text" value="<?= number_format($total_payamount ?? 0, 0) ?>" readonly>
                                                <button type="button" onclick="copyToClipboard('payTotal')" class="button-copy">Copy</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <!-- Confirm Payment Button -->
                                <div class="my-3 text-center">
                                    <button onclick="checkWallet()" class="button-copy">Confirm Payment</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="walletModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:9999;">
    <div style="background:#fff; padding:2rem; border-radius:0.5rem; max-width:400px; width:90%; max-height:80vh; overflow-y:auto; text-align:center; position:relative; word-break:break-word;">
        <h4 id="modalTitle" style="color: black">Status</h4>
        <p id="modalMessage"></p>
        <button onclick="closeModal()" style="padding:0.5rem 1rem; background:#bfa573; border:none; border-radius:0.3rem; color:#fff; cursor:pointer;">Close</button>
    </div>
</div>