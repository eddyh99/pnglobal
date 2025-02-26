<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12">
                <div class="send-signals">
                    <div class="title-signal-preview d-flex justify-content-between align-items-center">
                        <h4>PN GLOBAL OFFICIAL WALLET</h4>
                    </div>
                    <div class="main-send-signal d-flex flex-column align-items-center justify-content-center">
                        <div class="wallet-detailcard">
                            <div class="label">
                                USDT
                            </div>
                            <div class="value">
                                adsjJN945wkngsflkn
                            </div>
                            <div class="label">
                                TRAINLINK
                            </div>
                            <div class="value">
                                adsjJN945wadsjJN945wkngsflkn
                            </div>
                            <div class="label">
                                ASSET
                            </div>
                            <div class="value">
                                adsjJN945wadsjJN945wkngsflkn
                            </div>
                            <div class="label">
                                USDC
                            </div>
                            <div class="value">
                                0x85f5F1d1aA7DcE2FfA9D4f2fD3e6F0aAFbA4D3B7
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
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
    <?php } else if (!empty(session('success'))) { ?>
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

    <?php if (!empty(session('error_validation'))) { ?>
        setTimeout(function() {
            Swal.fire({
                html: '<?= trim(str_replace('"', '', json_encode($_SESSION['error_validation']))) ?>',
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