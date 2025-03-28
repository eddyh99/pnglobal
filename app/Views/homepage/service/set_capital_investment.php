<section class="investment-capital">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="investment-title">Set Investment Capital</div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="min-capital-text">The minimum of capital</div>
                <div class="min-capital-value">Loading...</div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="additional-capital-text">Additional Capital multiples of <span id="additional-step-display">$2000</span></div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button class="btn" type="button" id="decrease">-</button>
                    </div>
                    <input type="text" class="additional-capital-input form-control" id="additional-capital" value="Loading..." readonly>
                    <div class="input-group-append">
                        <button class="btn" type="button" id="increase">+</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="total-capital-text">Total of capital you want to use.</div>
                <div class="total-capital-display" id="total-capital-display">Loading...</div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="payment-description">The amount you have to pay.</div>
                <input type="text" class="payment-input form-control" id="payment-amount" value="Loading..." readonly />
                <div class="membership-days">Loading...</div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <button type="button" class="confirm-button" onclick="confirmPayment()">Confirm</button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="investment-note">
                    Note :<br>
                    1. You will pay <span id="percentage-fee-display">Loading...</span> of your total capital. (for <span id="membership-days-display">30</span> days membership) <br>
                    2. Once the payment is made, the amount of capital you have specified cannot be changed for <span id="membership-days-display2">30</span> days.
                </div>
            </div>
        </div>
    </div>
</section>
