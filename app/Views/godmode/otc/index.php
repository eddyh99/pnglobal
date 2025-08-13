<!-- Page Content  -->
<div class="content-page">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12">
                <div class="send-signals">
                    <div class="title-signal-preview d-flex justify-content-between align-items-center">
                        <h4>Calculator OTC</h4>
                    </div>
                    <div class="main-send-signal d-flex flex-column align-items-center justify-content-center">
                        <div class="row w-100">
                            <div class="form-addreferral col-8 mx-auto">
                                <div class="wrapper-addreferral">
                                    <label for="amountBtc">Amount BTC</label>
                                    <input type="number" id="amountBtc" name="amountBtc" class="form-control" placeholder="0.001" step="any">
                                </div>
                                <div class="wrapper-addreferral">
                                    <label for="buyPrice">Buy Price</label>
                                    <input type="number" id="buyPrice" name="buyPrice" class="form-control" placeholder="0" step="any">
                                </div>
                                <div class="wrapper-addreferral">
                                    <label for="sellPrice">Sell Price</label>
                                    <input type="number" id="sellPrice" name="sellPrice" class="form-control" placeholder="0" step="any">
                                </div>
                                <div class="wrapper-addreferral d-flex justify-content-center mt-4">
                                    <button type="button" id="calculateBtn" class="btn btn-primary">Calculate</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bagian hasil perhitungan, disembunyikan secara default -->
            <div id="result-container" class="form-addreferral col-8 mx-auto" style="display: none;">
                <div class="wrapper-addreferral">
                    <label for="resultAmountBuyUSDT">Amount Buy USDT</label>
                    <input type="number" id="resultAmountBuyUSDT" name="resultAmountBuyUSDT" class="form-control" value="0" step="any" readonly>
                </div>
                <div class="wrapper-addreferral">
                    <label for="resultAmountsellUSDT">Amount Sell USDT</label>
                    <input type="number" id="resultAmountsellUSDT" name="resultAmountsellUSDT" class="form-control" value="0" step="any" readonly>
                </div>
                <div class="wrapper-addreferral">
                    <label for="profit">Profit</label>
                    <input type="number" id="profit" name="profit" class="form-control" value="0" step="any" readonly>
                </div>
            </div>
        </div>
    </div>
</div>