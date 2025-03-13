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

<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12">
                <div class="send-signals">
                    <div class="title-signal-preview d-flex justify-content-between align-items-center">
                        <h4>Send Signals</h4>
                        <div class="active-api-card text-white">
                            <?php if (isset($api_key) && isset($api_secret) && !empty($api_key) && !empty($api_secret)): ?>
                                Active
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="30" viewBox="0 0 50 30" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M45 0H5C3.67392 0 2.40215 0.526784 1.46447 1.46447C0.526784 2.40215 0 3.67392 0 5V25C0 26.3261 0.526784 27.5979 1.46447 28.5355C2.40215 29.4732 3.67392 30 5 30H45C46.3261 30 47.5979 29.4732 48.5355 28.5355C49.4732 27.5979 50 26.3261 50 25V5C50 3.67392 49.4732 2.40215 48.5355 1.46447C47.5979 0.526784 46.3261 0 45 0ZM18.225 22L17.5 19.325H12.9L12.175 22H7.925L12.5 7.675H17.725L22.5 22H18.225ZM34.075 14.15C33.8951 14.7425 33.588 15.2886 33.175 15.75C32.7054 16.2366 32.1331 16.6124 31.5 16.85C30.7002 17.1455 29.8525 17.2896 29 17.275H27.9V22H24V7.725H29C30.447 7.62052 31.8836 8.03731 33.05 8.9C33.5194 9.32202 33.887 9.84498 34.1252 10.4296C34.3633 11.0141 34.4659 11.6451 34.425 12.275C34.4108 12.9148 34.2926 13.5481 34.075 14.15ZM40.525 22H36.65V7.725H40.525V22ZM16.125 13.825L16.725 16.15H13.7L14.3 13.825C14.3 13.5 14.5 13.125 14.6 12.65C14.7 12.175 14.825 11.7 14.925 11.225C15.0295 10.8297 15.1129 10.4291 15.175 10.025C15.175 10.35 15.35 10.75 15.45 11.275L15.825 12.725L16.125 13.825ZM30.1 11.325C30.2375 11.4667 30.3441 11.6354 30.4129 11.8205C30.4818 12.0055 30.5114 12.2029 30.5 12.4C30.5139 12.7695 30.4182 13.1348 30.225 13.45C30.0605 13.6971 29.8252 13.8888 29.55 14C29.2575 14.1229 28.9422 14.1825 28.625 14.175H27.85V10.85H28.85C29.0604 10.8404 29.2705 10.873 29.4681 10.946C29.6656 11.019 29.8465 11.1309 30 11.275L30.1 11.325Z" fill="#0DB82D" />
                                </svg>
                            <?php else: ?>
                                Inactive
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="30" viewBox="0 0 50 30" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M45 0H5C3.67392 0 2.40215 0.526784 1.46447 1.46447C0.526784 2.40215 0 3.67392 0 5V25C0 26.3261 0.526784 27.5979 1.46447 28.5355C2.40215 29.4732 3.67392 30 5 30H45C46.3261 30 47.5979 29.4732 48.5355 28.5355C49.4732 27.5979 50 26.3261 50 25V5C50 3.67392 49.4732 2.40215 48.5355 1.46447C47.5979 0.526784 46.3261 0 45 0ZM18.225 22L17.5 19.325H12.9L12.175 22H7.925L12.5 7.675H17.725L22.5 22H18.225ZM34.075 14.15C33.8951 14.7425 33.588 15.2886 33.175 15.75C32.7054 16.2366 32.1331 16.6124 31.5 16.85C30.7002 17.1455 29.8525 17.2896 29 17.275H27.9V22H24V7.725H29C30.447 7.62052 31.8836 8.03731 33.05 8.9C33.5194 9.32202 33.887 9.84498 34.1252 10.4296C34.3633 11.0141 34.4659 11.6451 34.425 12.275C34.4108 12.9148 34.2926 13.5481 34.075 14.15ZM40.525 22H36.65V7.725H40.525V22ZM16.125 13.825L16.725 16.15H13.7L14.3 13.825C14.3 13.5 14.5 13.125 14.6 12.65C14.7 12.175 14.825 11.7 14.925 11.225C15.0295 10.8297 15.1129 10.4291 15.175 10.025C15.175 10.35 15.35 10.75 15.45 11.275L15.825 12.725L16.125 13.825ZM30.1 11.325C30.2375 11.4667 30.3441 11.6354 30.4129 11.8205C30.4818 12.0055 30.5114 12.2029 30.5 12.4C30.5139 12.7695 30.4182 13.1348 30.225 13.45C30.0605 13.6971 29.8252 13.8888 29.55 14C29.2575 14.1229 28.9422 14.1825 28.625 14.175H27.85V10.85H28.85C29.0604 10.8404 29.2705 10.873 29.4681 10.946C29.6656 11.019 29.8465 11.1309 30 11.275L30.1 11.325Z" fill="#F80D0D" />
                                </svg>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="main-send-signal d-flex flex-column align-items-center justify-content-center">
                        <div class="signal-preview">
                            <div class="row">
                                <div class="col-12 col-md-6 all-buy">
                                    <div class="instruction-column instruction-buy">
                                        <span class="instruction-label">BUY</span>
                                        <span class="instruction-value">= $ 95000.48</span>
                                    </div>
                                    <div class="signal-section">
                                        <table class="signal-table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>PRICE</th>
                                                    <th>STATUS</th>
                                                    <th colspan="3">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- BUY A -->
                                                <tr data-pair-id="<?php echo (!empty($buy_a) ? $buy_a['pair_id'] : '') ?>">
                                                    <td>
                                                        <div class="signal-label buy-label">A</div>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="buy-a" class="signal-price" value="<?php echo (!empty($buy_a) ? number_format($buy_a['entry_price'], 2, '.', ',') : '') ?>" <?php echo (!empty($buy_a) ? "readonly" : "") ?>>
                                                    </td>
                                                    <td>
                                                        <div class="signal-status">
                                                            <?php echo (!empty($buy_a) ? $buy_a['status'] : 'Pending') ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button id="send-buy-a" class="signal-btn btn-ok" <?php echo (!empty($buy_a) ? "disabled" : "") ?>>BUY</button>
                                                    </td>
                                                    <td>
                                                        <button id="fill-buy-a" class="signal-btn btn-fill" <?php echo (!empty($buy_a) && strtolower($buy_a['status']) === 'filled' ? "disabled" : "") ?>>FILL</button>
                                                    </td>
                                                    <td>
                                                        <button id="del-buy-a" class="signal-btn btn-del">DEL</button>
                                                    </td>
                                                </tr>
                                                <!-- BUY B -->
                                                <tr data-pair-id="<?php echo (!empty($buy_b) ? $buy_b['pair_id'] : '') ?>">
                                                    <td>
                                                        <div class="signal-label buy-label">B</div>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="buy-b" class="signal-price" value="<?php echo (!empty($buy_b) ? number_format($buy_b['entry_price'], 2, '.', ',') : '') ?>" <?php echo (!empty($buy_b) ? "readonly" : "") ?>>
                                                    </td>
                                                    <td>
                                                        <div class="signal-status">
                                                            <?php echo (!empty($buy_b) ? $buy_b['status'] : 'Pending') ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button id="send-buy-b" class="signal-btn btn-ok" <?php echo (!empty($buy_b) ? "disabled" : "") ?>>BUY</button>
                                                    </td>
                                                    <td>
                                                        <button id="fill-buy-b" class="signal-btn btn-fill" <?php echo (!empty($buy_b) && strtolower($buy_b['status']) === 'filled' ? "disabled" : "") ?>>FILL</button>
                                                    </td>
                                                    <td>
                                                        <button id="del-buy-b" class="signal-btn btn-del">DEL</button>
                                                    </td>
                                                </tr>
                                                <!-- BUY C -->
                                                <tr data-pair-id="<?php echo (!empty($buy_c) ? $buy_c['pair_id'] : '') ?>">
                                                    <td>
                                                        <div class="signal-label buy-label">C</div>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="buy-c" class="signal-price" value="<?php echo (!empty($buy_c) ? number_format($buy_c['entry_price'], 2, '.', ',') : '') ?>" <?php echo (!empty($buy_c) ? "readonly" : "") ?>>
                                                    </td>
                                                    <td>
                                                        <div class="signal-status">
                                                            <?php echo (!empty($buy_c) ? $buy_c['status'] : 'Pending') ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button id="send-buy-c" class="signal-btn btn-ok" <?php echo (!empty($buy_c) ? "disabled" : "") ?>>BUY</button>
                                                    </td>
                                                    <td>
                                                        <button id="fill-buy-c" class="signal-btn btn-fill" <?php echo (!empty($buy_c) && strtolower($buy_c['status']) === 'filled' ? "disabled" : "") ?>>FILL</button>
                                                    </td>
                                                    <td>
                                                        <button id="del-buy-c" class="signal-btn btn-del">DEL</button>
                                                    </td>
                                                </tr>
                                                <!-- BUY D -->
                                                <tr data-pair-id="<?php echo (!empty($buy_d) ? $buy_d['pair_id'] : '') ?>">
                                                    <td>
                                                        <div class="signal-label buy-label">D</div>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="buy-d" class="signal-price" value="<?php echo (!empty($buy_d) ? number_format($buy_d['entry_price'], 2, '.', ',') : '') ?>" <?php echo (!empty($buy_d) ? "readonly" : "") ?>>
                                                    </td>
                                                    <td>
                                                        <div class="signal-status">
                                                            <?php echo (!empty($buy_d) ? $buy_d['status'] : 'Pending') ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button id="send-buy-d" class="signal-btn btn-ok" <?php echo (!empty($buy_d) ? "disabled" : "") ?>>BUY</button>
                                                    </td>
                                                    <td>
                                                        <button id="fill-buy-d" class="signal-btn btn-fill" <?php echo (!empty($buy_d) && strtolower($buy_d['status']) === 'filled' ? "disabled" : "") ?>>FILL</button>
                                                    </td>
                                                    <td>
                                                        <button id="del-buy-d" class="signal-btn btn-del">DEL</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- SELL SECTION -->
                                <div class="col-12 col-md-6 all-sell mt-5 mt-md-0">
                                    <div class="instruction-column instruction-sell">
                                        <span class="instruction-label">SELL</span>
                                        <span class="instruction-value">= $ 93000.48</span>
                                    </div>
                                    <div class="signal-section">
                                        <table class="signal-table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>PRICE</th>
                                                    <th>STATUS</th>
                                                    <th colspan="3">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- SELL A -->
                                                <tr data-pair-id="<?php echo (!empty($buy_a) ? $buy_a['pair_id'] : '') ?>">
                                                    <td>
                                                        <div class="signal-label sell-label">A</div>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="sell-a" class="signal-price" value="" <?php echo (empty($buy_a) || (isset($buy_a['status']) && strtolower($buy_a['status']) === 'new') ? "readonly" : "") ?>>
                                                    </td>
                                                    <td>
                                                        <div class="signal-status">
                                                            Pending
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button id="send-sell-a" class="signal-btn btn-ok" <?php echo (empty($buy_a) || (isset($buy_a['status']) && strtolower($buy_a['status']) === 'new') ? "disabled" : "") ?>>SELL</button>
                                                    </td>
                                                    <td>
                                                        <button id="fill-sell-a" class="signal-btn btn-fill" <?php echo (empty($buy_a) ? "disabled" : "") ?>>FILL</button>
                                                    </td>
                                                    <td>
                                                        <button id="del-sell-a" class="signal-btn btn-del" <?php echo (empty($buy_a) ? "disabled" : "") ?>>DEL</button>
                                                    </td>
                                                </tr>
                                                <!-- SELL B -->
                                                <tr data-pair-id="<?php echo (!empty($buy_b) ? $buy_b['pair_id'] : '') ?>">
                                                    <td>
                                                        <div class="signal-label sell-label">B</div>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="sell-b" class="signal-price" value="" <?php echo (empty($buy_b) || (isset($buy_b['status']) && strtolower($buy_b['status']) === 'new') ? "readonly" : "") ?>>
                                                    </td>
                                                    <td>
                                                        <div class="signal-status">
                                                            Pending
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button id="send-sell-b" class="signal-btn btn-ok" <?php echo (empty($buy_b) || (isset($buy_b['status']) && strtolower($buy_b['status']) === 'new') ? "disabled" : "") ?>>SELL</button>
                                                    </td>
                                                    <td>
                                                        <button id="fill-sell-b" class="signal-btn btn-fill" <?php echo (empty($buy_b) ? "disabled" : "") ?>>FILL</button>
                                                    </td>
                                                    <td>
                                                        <button id="del-sell-b" class="signal-btn btn-del" <?php echo (empty($buy_b) ? "disabled" : "") ?>>DEL</button>
                                                    </td>
                                                </tr>
                                                <!-- SELL C -->
                                                <tr data-pair-id="<?php echo (!empty($buy_c) ? $buy_c['pair_id'] : '') ?>">
                                                    <td>
                                                        <div class="signal-label sell-label">C</div>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="sell-c" class="signal-price" value="" <?php echo (empty($buy_c) || (isset($buy_c['status']) && strtolower($buy_c['status']) === 'new') ? "readonly" : "") ?>>
                                                    </td>
                                                    <td>
                                                        <div class="signal-status">
                                                            Pending
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button id="send-sell-c" class="signal-btn btn-ok" <?php echo (empty($buy_c) || (isset($buy_c['status']) && strtolower($buy_c['status']) === 'new') ? "disabled" : "") ?>>SELL</button>
                                                    </td>
                                                    <td>
                                                        <button id="fill-sell-c" class="signal-btn btn-fill" <?php echo (empty($buy_c) ? "disabled" : "") ?>>FILL</button>
                                                    </td>
                                                    <td>
                                                        <button id="del-sell-c" class="signal-btn btn-del" <?php echo (empty($buy_c) ? "disabled" : "") ?>>DEL</button>
                                                    </td>
                                                </tr>
                                                <!-- SELL D -->
                                                <tr data-pair-id="<?php echo (!empty($buy_d) ? $buy_d['pair_id'] : '') ?>">
                                                    <td>
                                                        <div class="signal-label sell-label">D</div>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="sell-d" class="signal-price" value="" <?php echo (empty($buy_d) || (isset($buy_d['status']) && strtolower($buy_d['status']) === 'new') ? "readonly" : "") ?>>
                                                    </td>
                                                    <td>
                                                        <div class="signal-status">
                                                            Pending
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button id="send-sell-d" class="signal-btn btn-ok" <?php echo (empty($buy_d) || (isset($buy_d['status']) && strtolower($buy_d['status']) === 'new') ? "disabled" : "") ?>>SELL</button>
                                                    </td>
                                                    <td>
                                                        <button id="fill-sell-d" class="signal-btn btn-fill" <?php echo (empty($buy_d) ? "disabled" : "") ?>>FILL</button>
                                                    </td>
                                                    <td>
                                                        <button id="del-sell-d" class="signal-btn btn-del" <?php echo (empty($buy_d) ? "disabled" : "") ?>>DEL</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 history-table-message">
                <div class="text-white">History</div>
                <table id="table_message" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>ORDER</th>
                            <th>PRICE</th>
                            <th>DATE</th>
                            <th>TIME</th>
                            <th>ADMIN</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>