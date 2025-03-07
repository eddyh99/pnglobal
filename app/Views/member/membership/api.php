<div class="content-page">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12 px-2">
                <div class="binance-fullcard">
                    <div class="binance-fullcard-header">
                        Connect Binance API
                    </div>
                    <form id="binance-api-form" method="post">
                        <div class="binance-detailcard">
                            <div class="label">
                                API Key
                            </div>
                            <div class="value">
                                <input type="text" name="api_key" id="api_key" value="">
                            </div>
                            <div class="label">
                                API Secret
                            </div>
                            <div class="value">
                                <input type="text" name="api_secret" id="api_secret" value="">
                            </div>
                        </div>
                        <div class="binance-fullcard-footer">
                            <button type="submit" class="save-btn" id="save-btn">SAVE</button>
                        </div>
                    </form>
                </div>

                <div class="binance-button-row">
                    <a href="/homepage/tutorial" class="get-api-btn">How to get API?</a>
                    <a href="#" class="support-btn">Contact Support</a>
                </div>

                <!-- Alert messages -->
                <div id="alert-success" class="alert alert-success" style="display: none; margin-top: 20px;"></div>
                <div id="alert-error" class="alert alert-danger" style="display: none; margin-top: 20px;"></div>
            </div>
        </div>
    </div>
</div>