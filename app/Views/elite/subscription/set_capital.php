<section class="elite-page">
    <div class="container mt-2">
        <div class="text-center mb-4">
            <h1 class="site-title"><span>HEDGE</span> FUND</h1>
            <p class="site-subtitle">Direct and Personalized Bitcoin Wallet Management.</p>
        </div>

        <div class="elite-investment">
            <form action="<?= BASE_URL ?>auth/postLogin" method="POST">
                <div class="row">
                    <div class="col-12">
                        <div class="min-capital-text">The minimum of capital</div>
                        <div class="min-capital-value">Loading...</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="additional-capital-text">Additional Capital multiplies of <span id="additional-step-display">$2000</span></div>
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
                        <div class="payment-description">The amount you have to send.</div>
                        <input type="text" class="payment-input form-control" id="payment-amount" value="Loading..." readonly />
                    </div>
                </div>
        
                <div class="row">
                    <div class="col-12">
                        <button type="button" class="confirm-button" onclick="confirmPayment()">Confirm</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</section>
