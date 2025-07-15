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
        <!-- Tab Navigation -->

        <!-- Tab Contents -->
        <div id="pn-global">
            <div class="row content-body">
                <div class="col-lg-12 dash-table-totalmember">
                    <h4 class="text-white my-3 text-uppercase fw-bold">Create Payment Link</h4>
                    <form action="<?= BASE_URL ?>godmode/course/dashboard/paymentlink">
                        <div class="row">
                            <div class="col-8">
                                <label class="text-white">Nominal</label>
                                <input type="text" name="nominal" class="form-control" value="<?= old('nominal') ?>">
                            </div>
                            <div class="col-4">
                                <label class="text-white">Currency</label>
                                <select name="currency" class="form-control text-danger">
                                    <option value="usdt" <?= old('currency') == 'usdt' ? 'selected' : '' ?>>USDT</option>
                                    <option value="usdc" <?= old('currency') == 'usdc' ? 'selected' : '' ?>>USDC</option>
                                    <option value="stripe" <?= old('currency') == 'stripe' ? 'selected' : '' ?>>Stripe</option>
                                    <option value="banktransfer" <?= old('currency') == 'banktransfer' ? 'selected' : '' ?>>Bank Transfer</option>
                                </select>
                            </div>

                            <div class="col-12 mt-2">
                                <label class="text-white">Description</label>
                                <input type="text" name="description" value="<?= old('description') ?>" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 my-2 text-center">
                                <button type="submit" class="btn btn-primary" onclick="this.disabled=true; this.innerText='Processing...'; this.form.submit();">CREATE</button>
                            </div>
                    </form>
                    <div class="col-12 mt-2 text-center">
                        <label class="text-white mt-2">Payment Link</label>

                        <form action="<?= BASE_URL ?>godmode/course/dashboard/sendpayment">
                            <div class="input-group mw-100">
                                <input type="text" id="paymentLink" name="paymentlink" class="form-control" style="background-color: transparent;" value="<?= $payment_link ?>" readonly>
                                <button class="mx-1 btn btn-primary" type="button" id="copyBtn">Copy</button>
                            </div>
                    </div>

                    <div class="col-12 text-center">
                        <label class="text-white">Email</label>
                        <select name="email" class="select2" style="width: 100%">
                            <?php foreach ($student as $s): ?>
                                <option><?= $s->email ?></option>
                            <?php endforeach ?>
                        </select>
                        <!-- <input type="text" name="email" class="form-control" value="<?= old('email') ?>"> -->
                    </div>
                    <div class="col-12 my-3 text-center">
                        <button type="submit" class="btn btn-primary" onclick="this.disabled=true; this.innerText='Sending...'; this.form.submit();">SEND</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>