<!-- Page Content -->
<div class="content-page mb-5">
    <div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow p-4" style="background-color: #2c2c2c; color: white; border-radius: 12px; width: 100%; max-width: 800px;">
            <h1 class="text-center mb-3">DEPOSIT</h1>
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

    </div>
    <div class="col-lg-12 mt-3 dash-table-totalmember">
                <h4 class="text-white my-3 text-uppercase fw-bold">History</h4>
                <table id="table_deposithistory" class="table table-striped" style="width:100%">
                    <thead class="thead_totalmember">
                        <tr>
                            <th>DATE</th>
                            <th>AMOUNT</th>
                            <th>DESCRIPTION</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
</div>
