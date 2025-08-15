<!-- Page Content  -->
<section class="elite-page">
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="site-title"><span>HEDGE</span> FUND</h1>
            <p class="site-subtitle">Direct and Personalized Bitcoin Wallet Management.</p>
        </div>
        <div id="bankAccountView" class="col-lg-12 mb-5 outer-border-wrapper">
            <h4 class="text-white font-bold m-3">Deposit Information</h4>
            <!-- Destination Bank -->
            <div class="border-wrapper">
                <h5 class="my-3 text-white text-start">Destination Bank</h5>
                <table class="invoice-table">
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
                            <span class="text-white">:</span>
                            <input id="viewRouting" type="text" value="<?= esc($routing ?? '-') ?>" readonly class="form-control-sm flex-grow-1">
                            <button type="button" onclick="copyToClipboard('viewRouting')" class="button-copy">Copy</button>
                        </td>
                    </tr>
                    <tr>
                        <th class="th-deposit">Account Number</th>
                        <td class="td-input">
                            <span class="text-white">:</span>
                            <input id="viewAccountNumber" type="text" value="<?= esc($account_number ?? '-') ?>" readonly class="form-control-sm flex-grow-1">
                            <button type="button" onclick="copyToClipboard('viewAccountNumber')" class="button-copy">Copy</button>
                        </td>
                    </tr>
                    <tr>
                        <th class="th-deposit">Casual</th>
                        <td class="td-input">
                            <span class="text-white">:</span>
                            <input id="viewCasual" type="text" value="<?= esc($order_id ?? '-') ?>" readonly class="form-control-sm flex-grow-1">
                            <button type="button" onclick="copyToClipboard('viewCasual')" class="button-copy">Copy</button>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- End Destination Bank -->
            <!-- Invoice Section -->
            <div class="border-wrapper">
                <h5 class="my-3 text-white text-start">Detail Amount Transfer</h5>
                <table>
                    <tr style=" height: 60px;">
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
                            <span class="text-white">:</span>
                            <input id="payTotal" type="text" value="$<?= number_format($total ?? 0, 0) ?>" readonly class="form-control-sm flex-grow-1 font-weight-bold">
                            <button type="button" onclick="copyToClipboard('payTotal')" class="button-copy">Copy</button>
                        </td>
                    </tr>
                    </table>
            </div>
            <!-- End Invoice Section -->
        </div>
    </div>
</section>