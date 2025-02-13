<section class="investment-capital">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="investment-title">Set Investment Capital</div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="investment-description">
                    The amount of capital you want to use.
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button" id="decrease">-</button>
                    </div>
                    <input type="number" class="investment-input form-control" id="capital-input" placeholder="Enter your capital" value="0" min="0" step="2000" required>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="increase">+</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="payment-description">
                The amount you have to pay.
            </div>
            <input type="text" class="payment-input form-control" placeholder="Enter your payment" required />
        </div>
        <div class="row">
            <div class="col-12">
                <button type="submit" class="confirm-button btn btn-primary">Confirm</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="investment-note">
                    Note :<br>
                    1. You will pay 11% of your total capital. (for 30 days membership) <br>
                    2. Once the payment is made, the amount of capital you have specified cannot be changed for 30 days.
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const capitalInput = document.getElementById('capital-input');

        document.getElementById('increase').addEventListener('click', function() {
            let value = parseInt(capitalInput.value) || 0;
            capitalInput.value = value + 2000;
            // console.log("increase");
        });

        document.getElementById('decrease').addEventListener('click', function() {
            let value = parseInt(capitalInput.value) || 0;
            if (value >= 2000) {
                capitalInput.value = value - 2000;
            }
        });

        capitalInput.addEventListener('change', function() {
            let value = parseInt(capitalInput.value) || 0;
            capitalInput.value = Math.round(value / 2000) * 2000;
        });
    });
</script>