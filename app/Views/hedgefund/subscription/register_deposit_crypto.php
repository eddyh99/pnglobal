<section class="elite-page">
    <div class="container mt-2">
        <div class="text-center mb-4">
            <h1 class="site-title"><span>HEDGE</span> FUND</h1>
            <p class="site-subtitle">Direct and Personalized Bitcoin Wallet Management.</p>
        </div>

        <div class="elite-investment">
            <div id="CryptoPayment" class="col-lg-12 mb-5">
                <div class="send-signals">
                    <div class="title-signal-preview text-center">
                        <h4>Deposit Information</h4>
                    </div>
                    <!-- QR Code Wallet Address -->
                    <div class="mt-3 text-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= urlencode($wallet->address) ?>"
                            alt="QR Code Wallet"
                            style="border: 1px solid #bfa573; padding: 10px; border-radius: 8px;">
                        <p class="mt-2">Scan this QR code to deposit</p>
                    </div>

                    <div class="mt-3" style="border: 1px solid #bfa573; padding: 1rem; border-radius: 0.5rem;">
                        <h5 class="mb-3">Destination Wallet</h5>
                        <table class="invoice-table">
                            <tr>
                                <th>invoice</th>
                                <td class="text-start">: <?= $order_id ?></td>
                            </tr>
                            <tr>
                                <th>Address Wallet</th>
                                <td class="text-start">
                                    <div class="copy-field">
                                        <span class="label-colon">:</span>
                                        <input id="addressWallet" type="text" value="<?= $wallet->address ?>" readonly>
                                        <button type="button" onclick="copyToClipboard('addressWallet')" class="button-copy">Copy</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Network Wallet</th>
                                <td class="text-start">: <?= $wallet->network ?></td>
                            </tr>
                        </table>
                        <p style="color: red;" class="mt-3">
                            Please make sure to send funds <strong>only to the selected wallet address and network</strong>. Sending to any other address or network may result in permanent loss of your funds.
                        </p>

                    </div>

                    <div class="mt-3" style="border: 1px solid #bfa573; padding: 1rem; border-radius: 0.5rem;">
                        <h5 class="mb-3">Detail Amount <?= $type ?></h5>
                        <table class="invoice-table">
                            <tr>
                                <th>Payment Amount</th>
                                <td class="text-start">: $ <?= number_format($total ?? 0, 0) ?></td>
                            </tr>
                            <tr>
                                <th>Processing Fee</th>
                                <td class="text-start">: $ <?= number_format($fee ?? 0, 0) ?></td>
                            </tr>
                            <tr>
                                <th>Total Amount</th>
                                <td class="text-start">
                                    <div class="copy-field">
                                        <span class="label-colon">:</span>
                                        <input id="payTotal" type="text" value="<?= number_format($payamount ?? 0, 0) ?>" readonly>
                                        <button type="button" onclick="copyToClipboard('payTotal')" class="button-copy">Copy</button>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- <button class="button-copy mt-5" type="button">Confirm</button> -->
                    <button class="button-copy mt-5" type="button" onclick="checkWallet()">Confirm</button>

                </div>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div id="walletModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:9999;">
        <div style="background:#fff; padding:2rem; border-radius:0.5rem; max-width:400px; width:90%; text-align:center; position:relative;">
            <h4 id="modalTitle">Status</h4>
            <p id="modalMessage"></p>
            <button onclick="closeModal()" style="padding:0.5rem 1rem; background:#bfa573; border:none; border-radius:0.3rem; color:#fff; cursor:pointer;">Close</button>
        </div>
    </div>

</section>