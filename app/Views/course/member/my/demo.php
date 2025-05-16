<?= view($menu); ?>
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
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#">Limit</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#">Market</a></li>
      </ul>

      <div class="mt-3">
        <div class="row">
          <!-- BUY PANEL -->
          <div class="col-md-6">
            <label class="form-label">Price</label>
            <input class="form-control" value="84937.13 USDT" />
            <input class="form-control mt-2" value="0.00000215 BTC" />
            <input type="range" class="form-range mt-3 range-slider w-100" />
            <div class="form-control mt-2">Total: <span class="highlight-price">2500 USDT</span></div>
            <div class="form-check mt-2">
              <input class="form-check-input" type="checkbox" id="tpSL1" />
              <label class="form-check-label text-white" for="tpSL1">TP / SL</label>
            </div>
            <input class="form-control mt-2" placeholder="TP Limit" />
            <input class="form-control mt-2" placeholder="SL Trigger" />
            <div class="mt-3 text-white-labels">Avbl: 0.00268741 USDT<br>Max Buy: 0.00000 BTC<br>Est Fee: 0.0000003
              BTC</div>
          </div>

          <!-- SELL PANEL -->
          <div class="col-md-6">
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
            <div class="mt-3 text-white-labels">Avbl: 0.00268741 USDT<br>Max Buy: 0.00000 BTC<br>Est Fee: 0.0000003
              BTC</div>
          </div>
        </div>
      </div>

      <!-- Order Tabs -->
      <ul class="nav nav-tabs mt-4">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#">Open Order (0)</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#">Order History</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#">Trade History</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#">Fund</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#">Grid Orders</a></li>
      </ul>
      <div class="tab-content mt-2">
        <div class="text-white-labels">No open orders. <span class="text-warning">Cancel All</span></div>
      </div>
    </div>

    <!-- MY TRADES -->
    <div class="col-md-3 trades">
      <h6>My Trades</h6>
      <div class="my-trades">
        <div class="d-flex justify-content-between">
          <span class="text-success">90.356</span><span class="highlight-price">0.00385</span><span>12:35:13</span>
        </div>
        <div class="d-flex justify-content-between">
          <span class="text-danger">90.356</span><span class="highlight-price">0.00385</span><span>12:35:13</span>
        </div>
      </div>
    </div>
  </div>
</div>