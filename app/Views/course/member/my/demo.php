<?= view($menu); ?>
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
<div class="container-fluid mt-3">
  <div class="row">
    <div class="col-12 text-center mt-3 mb-3">
      <h3>BTC/USDT: <span id="price-ticker">Loading...</span></h3>
    </div>
  </div>
  
  <div class="row">
    <div class="col-12">
      <div class="tradingview-widget-container" style="margin-top: 20px;">
        <div id="tradingview_btcusdt"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
        <script type="text/javascript">
          new TradingView.widget({
            "width": "100%",
            "height": 500,
            "symbol": "BINANCE:BTCUSDT",
            "interval": "1",
            "timezone": "Etc/UTC",
            "theme": "dark",
            "style": "1",
            "locale": "en",
            "toolbar_bg": "#000",
            "enable_publishing": false,
            "allow_symbol_change": true,
            "container_id": "tradingview_btcusdt"
          });
        </script>
      </div>
    </div>
  </div>

  <div class="row mt-3">
    <!-- ORDER BOOK -->
    <div class="col-md-3 order-book">
      <h6>ORDER BOOK</h6>
      <div class="progress mb-2" style="height: 5px;">
        <div id="buy-bar" class="progress-bar bg-success" style="width: 40%"></div>
        <div id="sell-bar" class="progress-bar bg-danger" style="width: 60%"></div>
      </div>
      <div class="d-flex justify-content-between text-muted small">
        <span id="buy-strength" class="text-white">40%</span><span id="sell-strength" class="text-white">60%</span>
      </div>

      <hr class="text-secondary" />
      <!-- Bids and Asks -->
      <div id="orderbook-rows"></div>
    </div>

    <!-- SPOT PANEL -->
    <div class="col-md-6 spot">
      <h6>SPOT</h6>
      <ul class="nav nav-tabs" id="spotTab" role="tablist">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" data-type="limit">Limit</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" data-type="market">Market</a></li>
      </ul>
    <div class="mt-3">
      <div class="row">
    
        <!-- BUY PANEL -->
        <div class="col-md-6">
          <form action="<?=BASE_URL?>course/member/buyposition" method="post">
            <h5 class="text-success mb-3">Buy</h5> <!-- ✅ Buy Label -->
            <input type="hidden" id="buytype" name="buytype" value="limit">
    
            <div id="priceWrapper">
              <label class="form-label">Price</label>
              <div class="input-group" style="border: 1px solid #b48b3d; background-color: #000; height: 45px; border-radius: 5px;">
                <input lang="en" required class="form-control no-spinner" id="price" name="price"
                       type="number" step="0.01" min="0" value="84937.13"
                       style="background-color: transparent; color: #b48b3d; border: none; box-shadow: none;" />
                <div class="input-group-append">
                  <span class="input-group-text">USDT</span>
                </div>
              </div>
    
              <div class="input-group mt-2" style="border: 1px solid #b48b3d; background-color: #000; height: 45px; border-radius: 5px;">
                <input lang="en" class="form-control no-spinner" id="qtybtc" name="qtybtc"
                       type="number" step="0.000001" min="0"
                       style="background-color: transparent; color: #b48b3d; border: none; box-shadow: none;" />
                <div class="input-group-append">
                  <span class="input-group-text">BTC</span>
                </div>
              </div>
            </div>
    
            <input type="range" class="form-range mt-3 range-slider w-100" id="btcSlider"
                   min="10" max="<?= $balance->available_balance ?>" step="1" value="10" />
    
            <p class="mt-2">Amount in USDT: </p>
            <div class="input-group mt-2" style="border: 1px solid #b48b3d; background-color: #000; height: 45px; border-radius: 5px;">
                <input lang="en" required class="form-control no-spinner" id="usdtAmount" name="usdtAmount"
                       type="number" step="1" min="10" value="10"
                       style="background-color: transparent; color: #b48b3d; border: none; box-shadow: none;" />
                <div class="input-group-append">
                  <span class="input-group-text">USDT</span>
                </div>
            </div>
    
            <div class="form-check mt-2">
              <input class="form-check-input" type="checkbox" id="tpSL1" name="tpsl"/>
              <label class="form-check-label text-white" for="tpSL1">TP / SL</label>
            </div>
    
            <input class="form-control mt-2" id="tplimit" name="tplimit" placeholder="TP Limit" readonly />
            <input class="form-control mt-2" id="sllimit" name="sllimit" placeholder="SL Trigger" readonly />
    
            <div class="mt-3 text-white-labels">
              Avbl: <?= number_format($balance->available_balance, 2) ?> USDT<br>
              Max Buy: <span id="maxbuy">0</span> BTC
            </div>
    
            <!-- ✅ Buy Button -->
            <button type="submit" class="btn btn-success mt-3 w-100" style="background-color: #198754 !important;color: white !important;border-color: #198754 !important;">Buy</button>
          </form>
        </div>
    
        <!-- SELL PANEL -->
        <div class="col-md-6">
          <form action="<?=BASE_URL?>course/demo/sellposition" method="post">
            <h5 class="text-danger mb-3">Sell</h5> <!-- ✅ Sell Label -->
            <input type="hidden" id="selltype" name="selltype" value="limit">
    
            <label class="form-label">Price</label>
            <input class="form-control" value="84937.13 USDT" />
            <input class="form-control mt-2" value="0.00000215 BTC" />
    
            <input type="range" class="form-range mt-3 range-slider w-100" />
    
            <div class="form-control mt-2">Total: <span class="highlight-price">2500 USDT</span></div>
    
            <div class="form-check mt-2">
              <input class="form-check-input" type="checkbox" id="tpSL2" />
              <label class="form-check-label text-white" for="tpSL2">TP / SL</label>
            </div>
    
            <input class="form-control mt-2" placeholder="TP Limit" />
            <input class="form-control mt-2" placeholder="SL Trigger" />
    
            <div class="mt-3 text-white-labels">
              Avbl: <?= number_format($balance->available_balance, 6) ?> USDT<br>
              Max Sell: <?= number_format($balance->btc_qty, 6) ?> BTC
            </div>
    
            <!-- ✅ Sell Button -->
            <button type="submit" class="btn btn-danger mt-3 w-100" style="background-color: #cc3300 !important;color: white !important;border-color: #cc3300 !important;">Sell</button>
          </form>
        </div>
    
      </div>
    </div>

      <!-- Order Tabs -->
      <ul class="nav nav-tabs mt-4">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#">Open Order (0)</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#">Order History</a></li>
      </ul>
      <div class="tab-content mt-2">
        <div class="text-white-labels">No open orders. <span class="text-warning">Cancel All</span></div>
      </div>
    </div>

    <!-- MY TRADES -->
    <div class="col-md-3 trades">
      <h6>My Trades</h6>
      <div class="my-trades">
        <?php foreach ($history as $ht):
                if ($ht->order_type=="buy"):
        ?>
            
            <div class="d-flex justify-content-between">
              <span class="text-success"><?=$ht->order_price?></span><span class="highlight-price"><?=$ht->btc_qty?></span><span><?=$ht->update_at?></span>
            </div>
        <?php else:?>
            <div class="d-flex justify-content-between">
              <span class="text-danger"><?=$ht->order_price?></span><span class="highlight-price"><?=$ht->btc_qty?></span><span><?=$ht->update_at?></span>
            </div>
        <?php endif; 
            endforeach;?>
      </div>
    </div>
  </div>
</div>