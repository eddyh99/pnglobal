<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid">
        <div class="row content-body">
            <!-- <div class="col-lg-12">
                <a class="text-white" href="<?= BASE_URL ?>godmode/payment">BACK</a>
            </div> -->
            <div class="col-lg-10 mx-auto">
                <!-- Detail -->
                <div class="dash-detailmember">
                    <div class="header">Request Payment</div>

                    <div class="label">Email</div>
                    <div class="value">
                        <span>
                            <?= $email ?>
                        </span>
                    </div>

                    <!-- Membership Status -->
                    <?php if (!empty($payment->recipient)): ?>
                        <div class="label">Recipient Name</div>
                        <div class="value">
                            <span><?= $payment->recipient ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($payment->account_type)): ?>
                        <div class="label">Account Type</div>
                        <div class="value">
                            <span><?= $payment->account_type ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($payment->address)): ?>
                        <div class="label">Address</div>
                        <div class="value">
                            <span><?= $payment->address ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($payment->network)): ?>
                        <div class="label">Network</div>
                        <div class="value">
                            <span><?= $payment->network ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($payment->routing_number)): ?>
                        <div class="label">Routing Number</div>
                        <div class="value">
                            <span><?= $payment->routing_number ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($payment->wallet_address)): ?>
                        <div class="label">Wallet Address</div>
                        <div class="value">
                            <span><?= $payment->wallet_address ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($payment->account_number)): ?>
                        <div class="label">Account Number</div>
                        <div class="value">
                            <span><?= $payment->account_number ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($payment->swift_code)): ?>
                        <div class="label">SWIFT Code</div>
                        <div class="value">
                            <span><?= $payment->swift_code ?></span>
                        </div>
                    <?php endif; ?>

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

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            Swal.fire({
                text: 'Berhasil disalin!',
                showCloseButton: true,
                showConfirmButton: false,
                background: '#E1FFF7',
                color: '#000000',
                position: 'top-end',
                timer: 1500,
                timerProgressBar: true,
            });
        }, function(err) {
            console.error('Gagal menyalin: ', err);
        });
    }
</script>