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
<div class="content-page mb-5" style="background-color: #000000;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="set-investment-container">
                    <div class="row">
                        <div class="col-12">
                            <div class="investment-title">SET INVESTMENT CAPITAL</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="min-capital-text">The minimum of capital</div>
                            <div class="min-capital-value">$ 8000</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="additional-capital-text">Additional Capital multiples of $2000</div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button class="btn" type="button" id="decrease">-</button>
                                </div>
                                <input type="text" class="additional-capital-input form-control" id="additional-capital" value="$ 0" readonly>
                                <div class="input-group-append">
                                    <button class="btn" type="button" id="increase">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="total-capital-text">Total of capital you want to use.</div>
                            <div class="total-capital-display" id="total-capital-display">$ 8000</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="payment-description">The amount you have to pay.</div>
                            <input type="text" class="payment-input form-control" id="payment-amount" value="€ 520" readonly />
                            <div class="membership-days">30 Days Membership</div>
                        </div>
                    </div>

                    <!-- <div class="row">
                        <div class="col-12">
                        </div>
                    </div> -->

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="confirm-button btn" onclick="confirmPayment()">Confirm</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="investment-note">
                                Note :<br>
                                1. You will pay 11% of 70% of your total capital. (for 30 days membership) <br>
                                2. Once the payment is made, the amount of capital you have specified cannot be changed for 30 days.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>