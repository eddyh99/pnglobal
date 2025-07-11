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

<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12">
                <a class="text-white" href="<?= BASE_URL ?>godmode/payment/<?= $type ?>">BACK</a>
            </div>
            <div class="col-lg-10 mx-auto">
                <!-- Detail -->
                <div class="dash-detailmember">
                    <div class="header">Request Payment</div>

                    <!-- Membership Status -->
                    <div class="label">Email</div>
                    <div class="value">
                        <span>
                            <?= $payment->email ?>
                        </span>
                    </div>

                    <div class="label">Amount</div>
                    <div class="value">
                        <span>
                            <?= number_format($payment->amount, 8, '.', '') ?>
                        </span>
                    </div>
                    <div class="label">Fee USDT</div>
                    <div class="value">
                        <span>
                            <?php $fee_usdt = 5 + ($payment->withdraw_type != 'btc' ? ($payment->amount * 0.01) : 0 );
                            $fee_btc = 0;
                            echo ($fee_usdt);  ?>
                        </span>
                    </div>
                    <?php if($payment->withdraw_type == 'btc'): ?>
                        <div class="label">Fee BTC</div>
                    <div class="value">
                        <span>
                            <?php $fee_btc = number_format($payment->amount * 0.01, 8, '.', '');
                            echo ($fee_btc);  ?>
                        </span>
                    </div>
                    <?php endif ?>
                    <div class="label">Received Amount</div>
                    <div class="value">
                        <button class="btn btn-copy p-0" onclick="copyToClipboard('<?= htmlspecialchars($payment->amount - ($payment->withdraw_type != 'btc' ? $fee_usdt : $fee_btc )) ?>')">
                            <span class="mr-2">
                                <?= $payment->amount - ($payment->withdraw_type != 'btc' ? $fee_usdt : $fee_btc ) ?>
                            </span>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.16675 12.5C3.39018 12.5 3.00189 12.5 2.69561 12.3731C2.28723 12.204 1.96277 11.8795 1.79362 11.4711C1.66675 11.1649 1.66675 10.7766 1.66675 10V4.33333C1.66675 3.39991 1.66675 2.9332 1.8484 2.57668C2.00819 2.26308 2.26316 2.00811 2.57676 1.84832C2.93328 1.66666 3.39999 1.66666 4.33341 1.66666H10.0001C10.7767 1.66666 11.1649 1.66666 11.4712 1.79353C11.8796 1.96269 12.2041 2.28714 12.3732 2.69553C12.5001 3.00181 12.5001 3.39009 12.5001 4.16666M10.1667 18.3333H15.6667C16.6002 18.3333 17.0669 18.3333 17.4234 18.1517C17.737 17.9919 17.992 17.7369 18.1518 17.4233C18.3334 17.0668 18.3334 16.6001 18.3334 15.6667V10.1667C18.3334 9.23324 18.3334 8.76653 18.1518 8.41001C17.992 8.09641 17.737 7.84144 17.4234 7.68165C17.0669 7.5 16.6002 7.5 15.6667 7.5H10.1667C9.23333 7.5 8.76662 7.5 8.4101 7.68165C8.09649 7.84144 7.84153 8.09641 7.68174 8.41001C7.50008 8.76653 7.50008 9.23324 7.50008 10.1667V15.6667C7.50008 16.6001 7.50008 17.0668 7.68174 17.4233C7.84153 17.7369 8.09649 17.9919 8.4101 18.1517C8.76662 18.3333 9.23333 18.3333 10.1667 18.3333Z" stroke="#8a6d3b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>

                    <!-- Registration date -->
                    <div class="label">Requested At</div>
                    <div class="value">
                        <?php
                        $dateString = $payment->requested_at;
                        $date = new DateTime($dateString);
                        $formattedDate = $date->format('d F Y');
                        echo $formattedDate;
                        ?>
                    </div>

                    <!-- Subscription Status -->
                    <div class="label">Payment Type</div>
                    <div class="value"><?= $payment->withdraw_type ?></div>

                    <!-- Subscription Status -->
                    <div class="label">Detail Payment</div>
                    <div class="value">
                        <?php if ($payment->withdraw_type != "fiat") { ?>

                            <input class="me-2" type="text" name="" id="wallet" class="form-control" value="<?= @$payment->wallet_address ?>" readonly style="min-width: 28ch;">
                            <a class="btn btn-copy me-2" id="btnwallet">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.16675 12.5C3.39018 12.5 3.00189 12.5 2.69561 12.3731C2.28723 12.204 1.96277 11.8795 1.79362 11.4711C1.66675 11.1649 1.66675 10.7766 1.66675 10V4.33333C1.66675 3.39991 1.66675 2.9332 1.8484 2.57668C2.00819 2.26308 2.26316 2.00811 2.57676 1.84832C2.93328 1.66666 3.39999 1.66666 4.33341 1.66666H10.0001C10.7767 1.66666 11.1649 1.66666 11.4712 1.79353C11.8796 1.96269 12.2041 2.28714 12.3732 2.69553C12.5001 3.00181 12.5001 3.39009 12.5001 4.16666M10.1667 18.3333H15.6667C16.6002 18.3333 17.0669 18.3333 17.4234 18.1517C17.737 17.9919 17.992 17.7369 18.1518 17.4233C18.3334 17.0668 18.3334 16.6001 18.3334 15.6667V10.1667C18.3334 9.23324 18.3334 8.76653 18.1518 8.41001C17.992 8.09641 17.737 7.84144 17.4234 7.68165C17.0669 7.5 16.6002 7.5 15.6667 7.5H10.1667C9.23333 7.5 8.76662 7.5 8.4101 7.68165C8.09649 7.84144 7.84153 8.09641 7.68174 8.41001C7.50008 8.76653 7.50008 9.23324 7.50008 10.1667V15.6667C7.50008 16.6001 7.50008 17.0668 7.68174 17.4233C7.84153 17.7369 8.09649 17.9919 8.4101 18.1517C8.76662 18.3333 9.23333 18.3333 10.1667 18.3333Z" stroke="#8a6d3b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                            <?php } else {
                            $details = is_string($payment->payment_details) ? json_decode($payment->payment_details, true) : $payment->payment_details;

                            // Jika payment_details masih berupa objek, konversi ke array
                            if (is_object($details)) {
                                $details = (array) $details;
                            }

                            if ($details) { ?>
                                <table class="table" width="300px">
                                    <thead>
                                        <tr>
                                            <th>Field</th>
                                            <th>Value</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Tambahkan wallet address ke dalam details jika ada
                                        if (!empty($payment->wallet_address)) {
                                            $details['account_number'] = $payment->wallet_address;
                                        }

                                        foreach ($details as $key => $value) {
                                            if ($value !== null && $value !== '') { ?>
                                                <tr>
                                                    <td><?= ucfirst(str_replace('_', ' ', $key)) ?></td>
                                                    <td><?= htmlspecialchars($value) ?></td>
                                                    <td>
                                                        <button class="btn btn-copy me-2" onclick="copyToClipboard('<?= htmlspecialchars($value) ?>')">
                                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M4.16675 12.5C3.39018 12.5 3.00189 12.5 2.69561 12.3731C2.28723 12.204 1.96277 11.8795 1.79362 11.4711C1.66675 11.1649 1.66675 10.7766 1.66675 10V4.33333C1.66675 3.39991 1.66675 2.9332 1.8484 2.57668C2.00819 2.26308 2.26316 2.00811 2.57676 1.84832C2.93328 1.66666 3.39999 1.66666 4.33341 1.66666H10.0001C10.7767 1.66666 11.1649 1.66666 11.4712 1.79353C11.8796 1.96269 12.2041 2.28714 12.3732 2.69553C12.5001 3.00181 12.5001 3.39009 12.5001 4.16666M10.1667 18.3333H15.6667C16.6002 18.3333 17.0669 18.3333 17.4234 18.1517C17.737 17.9919 17.992 17.7369 18.1518 17.4233C18.3334 17.0668 18.3334 16.6001 18.3334 15.6667V10.1667C18.3334 9.23324 18.3334 8.76653 18.1518 8.41001C17.992 8.09641 17.737 7.84144 17.4234 7.68165C17.0669 7.5 16.6002 7.5 15.6667 7.5H10.1667C9.23333 7.5 8.76662 7.5 8.4101 7.68165C8.09649 7.84144 7.84153 8.09641 7.68174 8.41001C7.50008 8.76653 7.50008 9.23324 7.50008 10.1667V15.6667C7.50008 16.6001 7.50008 17.0668 7.68174 17.4233C7.84153 17.7369 8.09649 17.9919 8.4101 18.1517C8.76662 18.3333 9.23333 18.3333 10.1667 18.3333Z" stroke="#8a6d3b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                        </button>
                                                    </td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                </table>
                        <?php }
                        }
                        ?>
                    </div>
                    <div class="header d-flex justify-content-end">
                        <form action="<?= BASE_URL ?>godmode/payment/payment_reject" method="POST">
                            <input type="hidden" name="reqid" value="<?= $id ?>">
                            <input type="hidden" name="idmember" value="<?= $payment->member_id ?>">
                            <button class="btn btn-danger" <?= ($payment->status != "pending" ? "disabled" : "") ?>>Reject</button>
                        </form>
                        <form action="<?= BASE_URL ?>godmode/payment/payment_process" method="POST">
                            <input type="hidden" name="fee_usdt" value="<?= $fee_usdt ?>">
                            <input type="hidden" name="fee_btc" value="<?= $fee_btc ?>">
                            <input type="hidden" name="reqid" value="<?= $id ?>">
                            <input type="hidden" name="email" value="<?= $payment->email ?>">
                            <button class="upgrade-btn mx-2" <?= ($payment->status != "pending" ? "disabled" : "") ?>>Process</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    <?php if (!empty(session('success'))) { ?>
        setTimeout(function() {
            Swal.fire({
                text: `<?= session('success') ?>`,
                showCloseButton: true,
                showConfirmButton: false,
                background: '#E1FFF7',
                color: '#000000',
                position: 'top-end',
                timer: 3000,
                timerProgressBar: true,
            });
        }, 100);
    <?php } ?>

    <?php if (!empty(session('failed'))) { ?>
        setTimeout(function() {
            Swal.fire({
                text: `<?= session('failed') ?>`,
                showCloseButton: true,
                showConfirmButton: false,
                background: '#FFE4DC',
                color: '#000000',
                position: 'top-end',
                timer: 3000,
                timerProgressBar: true,
            });
        }, 100);
    <?php } ?>
</script>