<section class="elite-page">
    <div class="container mt-2">
        <div class="text-center mb-4">
            <h1 class="site-title"><span>HEDGE</span> FUND</h1>
            <p class="site-subtitle">Direct and Personalized Bitcoin Wallet Management.</p>
        </div>

        <div class="elite-investment">
            <div id="bankAccountView" class="col-lg-12 mb-5">
                <div class="send-signals">
                    <div class="title-signal-preview d-flex justify-content-between align-items-center">
                        <h4>Deposit Information</h4>
                    </div>
                    <div class="mt-3" style="border: 1px solid #bfa573; padding: 1rem; border-radius: 0.5rem;">
                        <h5 class="mb-3">Destination US Bank</h5>
                        <table class="invoice-table">
                            <tr>
                                <th>Name</th>
                                <td class="text-start">: <span id="viewName"><?= esc($bank->us_bank_account_name) ?></span></td>
                            </tr>
                            <tr>
                                <th>Account Type</th>
                                <td class="text-start">: <span id="viewType"><?= esc($bank->us_bank_account_type ?? '-') ?></span></td>
                            </tr>
                            <tr>
                                <th>Routing Number</th>
                                <td>
                                    <div class="copy-field">
                                        <span class="label-colon">:</span>
                                        <input id="viewRouting" type="text" value="<?= esc($bank->us_bank_routing_number ?? '-') ?>" readonly>
                                        <button type="button" onclick="copyToClipboard('viewRouting')" class="button-copy">Copy</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Account Number</th>
                                <td>
                                    <div class="copy-field">
                                        <span class="label-colon">:</span>
                                        <input id="viewAccountNumber" type="text" value="<?= esc($bank->us_bank_account_number ?? '-') ?>" readonly>
                                        <button type="button" onclick="copyToClipboard('viewAccountNumber')" class="button-copy">Copy</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Causal</th>
                                <td>
                                    <div class="copy-field">
                                        <span class="label-colon">:</span>
                                        <input id="viewCasual" type="text" value="<?= esc($order_id ?? '-') ?>" readonly>
                                        <button type="button" onclick="copyToClipboard('viewCasual')" class="button-copy">Copy</button>
                                    </div>
                                </td>
                            </tr>

                        </table>

                    </div>

                    <div class="mt-3" style="border: 1px solid #bfa573; padding: 1rem; border-radius: 0.5rem;">
                        <h5 class="mb-3">Detail Amount Transfer</h5>
                        <table class="invoice-table">
                            <tr>
                                <th>Payment Amount</th>
                                <td class="text-start">: $ <?= number_format($payamount ?? 0, 0) ?></td>
                            </tr>
                            <tr>
                                <th>Bank Processing Fee</th>
                                <td class="text-start">: $ <?= number_format($fee ?? 0, 0) ?></td>
                            </tr>
                            <tr>
                                <th>Total Amount</th>
                                <td class="text-start">
                                    <div class="copy-field">
                                        <span class="label-colon">:</span>
                                        <input id="payTotal" type="text" value="<?= number_format($total ?? 0, 0) ?>" readonly>
                                        <button type="button" onclick="copyToClipboard('payTotal')" class="button-copy">Copy</button>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>